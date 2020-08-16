<?php

namespace App\Http\Controllers\Front\Payments;

use App\Http\Controllers\Controller;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Checkout\CheckoutRepository;
use App\Shop\Fairs\Fair;
use App\Shop\Fairs\Repositories\FairRepository;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Shop\Shipping\ShippingInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LivePixel\MercadoPago\MP;
use Ramsey\Uuid\Uuid;
use Shippo_Shipment;
use Shippo_Transaction;

class PayOnDeliveryController extends Controller
{
    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepo;

    /**
     * @var CourierRepositoryInterface
     */
    protected $courierRepo;

    /**
     * @var int $shipping
     */
    private $shippingFee;

    private $rateObjectId;

    private $shipmentObjId;

    private $billingAddress;

    private $carrier;

    /**
     * BankTransferController constructor.
     *
     * @param Request $request
     * @param CartRepositoryInterface $cartRepository
     * @param ShippingInterface $shippingRepo
     */
    public function __construct(
        Request $request,
        CartRepositoryInterface $cartRepository,
        CourierRepositoryInterface $courierRepository,
        ShippingInterface $shippingRepo
    )
    {
        $this->cartRepo = $cartRepository;
        $this->courierRepo = $courierRepository;
        $rateObjId = null;
        $shipmentObjId = null;
        $billingAddress = $request->input('billing_address');

        if ($request->has('rate')) {
            if ($request->input('rate') != '') {

                $rate_id = $request->input('rate');
                $rates = $shippingRepo->getRates($request->input('shipment_obj_id'));
                $rate = collect($rates->results)->filter(function ($rate) use ($rate_id) {
                    return $rate->object_id == $rate_id;
                })->first();

                $fee = $rate->amount;
                $rateObjId = $rate->object_id;
                $shipmentObjId = $request->input('shipment_obj_id');
                $this->carrier = $rate;
            }
        }

        $this->shippingFee = 0;
        $this->rateObjectId = $rateObjId;
        $this->shipmentObjId = $shipmentObjId;
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $fairRepo = new FairRepository(new Fair);
        $fair = $fairRepo->findFairById($fairRepo->findLastFair());

//        dd($fair->orders());
        $mp = new MP(env('MP_APP_ID'), env('MP_APP_SECRET'));
            foreach($fair->orders as $order) {

//                //Verificar o pagamento dos pedidos feitos no mercado-pago
                if(!is_null($order->mercado_pago_reference_id)){


                    $retorno = $mp->get(
                        "/v1/payments/search",
                        array(
                            "external_reference" => $order->reference
                        )
                    );
//                    dump($retorno);
                    $results = $retorno['response']['results'];
                    if(!empty($results)){
                        dump($order->id);
                        $status = $results[0]['status_detail'];
                        dump($status);

                        if($status == "cc_rejected_bad_filled_card_number"
                                ||$status ==  "cc_rejected_bad_filled_date"
                                ||$status ==  "cc_rejected_bad_filled_other"
                                ||$status ==  "cc_rejected_bad_filled_security_code"
                                ||$status ==  "cc_rejected_blacklist"
                                ||$status ==  "cc_rejected_call_for_authorize"
                                ||$status ==  "cc_rejected_card_disabled"
                                ||$status ==  "cc_rejected_card_error"
                                ||$status ==  "cc_rejected_duplicated_payment"
                                ||$status ==  "cc_rejected_high_risk"
                                ||$status ==  "cc_rejected_insufficient_amount"
                                ||$status ==  "cc_rejected_invalid_installments"
                                ||$status ==  "cc_rejected_max_attempts"
                                ||$status ==  "cc_rejected_other_reason") {
                            dump('recusado');
                            $order->order_status_id = 3;
                        }
                         if($status == 'pending_contingency' ||
                               $status ==  'pending_review_manual' ||
                               $status ==  'pending_waiting_payment') {
                             dump('pendente');
                             $order->order_status_id = 2;
                         }

                         if($status == 'accredited'){
                                dump('aprovado');
                                $order->order_status_id = 1;

                        }
                        $order->save();


                                /*  approved - accredited
                            *  in_process - pending_contingency
                            *  in_process - pending_review_manual
                            *  rejected - cc_rejected_bad_filled_card_number
                            *  rejected - cc_rejected_bad_filled_date
                            *  rejected - cc_rejected_bad_filled_other
                            *  rejected - cc_rejected_bad_filled_security_code
                            *  rejected - cc_rejected_blacklist
                            *  rejected - cc_rejected_call_for_authorize
                            *  rejected - cc_rejected_card_disabled
                            *  rejected - cc_rejected_card_error
                            *  rejected - cc_rejected_duplicated_payment
                            *  rejected - cc_rejected_high_risk
                            *  rejected - cc_rejected_insufficient_amount
                            *  rejected - cc_rejected_invalid_installments
                            *  rejected - cc_rejected_max_attempts
                            *  rejected - cc_rejected_other_reason
                                */
                        }
                    }
//                    dd($order);
                }
            }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $checkoutRepo = new CheckoutRepository;
        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $os = $orderStatusRepo->findByName('Pagar na Entrega');
        $courier = $this->courierRepo->findCourierById(intval(request()->get('courier_id')));

        $order = $checkoutRepo->buildCheckoutItems([
            'reference' => Uuid::uuid4()->toString(),
            'courier_id' => $request->input('courier_id'),
            'customer_id' => $request->user()->id,
            'address_id' => $request->input('billing_address'),
            'order_status_id' => $os->id,
            'payment' => strtolower(config('pay-on-delivery.name')),
            'discounts' => 0,
            'total_products' => $this->cartRepo->getSubTotal(),
            'total' => $this->cartRepo->getTotal(2, $courier->cost),
            'total_shipping' => $courier->cost,
            'total_paid' => 0,
            'tax' => $this->cartRepo->getTax()
        ]);

        if (env('ACTIVATE_SHIPPING') == 1) {
            $shipment = Shippo_Shipment::retrieve($this->shipmentObjId);

            $details = [
                'shipment' => [
                    'address_to' => json_decode($shipment->address_to, true),
                    'address_from' => json_decode($shipment->address_from, true),
                    'parcels' => [json_decode($shipment->parcels[0], true)]
                ],
                'carrier_account' => $this->carrier->carrier_account,
                'servicelevel_token' => $this->carrier->servicelevel->token
            ];

            $transaction = Shippo_Transaction::create($details);

            if ($transaction['status'] != 'SUCCESS'){
                Log::error($transaction['messages']);
                return redirect()->route('checkout.index')->with('error', 'There is an error in the shipment details. Check logs.');
            }

            $orderRepo = new OrderRepository($order);
            $orderRepo->updateOrder([
                'courier' => $this->carrier->provider,
                'label_url' => $transaction['label_url'],
                'tracking_number' => $transaction['tracking_number']
            ]);
        }

        Cart::destroy();

        return redirect()->route('accounts', ['tab' => 'orders'])->with('message', 'Pedido Cadastrado com Sucesso, Aguarde o Processamento');
    }
}