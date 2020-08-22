<?php

namespace App\Http\Controllers\Front;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Cart\Requests\CartCheckoutRequest;
use App\Shop\Cart\Requests\CartDeliveryCheckoutRequest;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Carts\Requests\PayPalCheckoutExecutionRequest;
use App\Shop\Carts\Requests\StripeExecutionRequest;
use App\Shop\Checkout\CheckoutRepository;
use App\Shop\Checkout\Requests\CheckoutRequest;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Shop\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use App\Shop\PaymentMethods\Paypal\Repositories\PayPalExpressCheckoutRepository;
use App\Shop\PaymentMethods\Stripe\Exceptions\StripeChargingErrorException;
use App\Shop\PaymentMethods\Stripe\StripeRepository;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Shipping\ShippingInterface;
use Exception;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use LivePixel\MercadoPago\MP;
use PayPal\Exception\PayPalConnectionException;
use Ramsey\Uuid\Uuid;

class CheckoutController extends Controller
{
    use ProductTransformable;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepo;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepo;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepo;

    /**
     * @var PayPalExpressCheckoutRepository
     */
    private $payPal;

    /**
     * @var ShippingInterface
     */
    private $shippingRepo;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CourierRepositoryInterface $courierRepository,
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        ProductRepositoryInterface $productRepository,
        OrderRepositoryInterface $orderRepository,
        ShippingInterface $shipping
    ) {
        $this->cartRepo = $cartRepository;
        $this->courierRepo = $courierRepository;
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->productRepo = $productRepository;
        $this->orderRepo = $orderRepository;
        $this->payPal = new PayPalExpressCheckoutRepository;
        $this->shippingRepo = $shipping;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CartDeliveryCheckoutRequest $request)
    {
        //$this->neededBag();


        $customer = $request->user();
        $rates = null;
        $shipment_object_id = null;

//        $error = false;
//        $carItens = $this->cartRepo->getCartItems();
        $msgErros = [];



//        if($error){
//
//
//            $couriers = $this->courierRepo->allEnable();
//
//            return view('front.carts.cart', [
//                'cartItems' => $this->cartRepo->getCartItemsTransformed(),
//                'subtotal' => $this->cartRepo->getSubTotal(),
//                'tax' => $this->cartRepo->getTax(),
//                'couriers' => $couriers,
//                'total' => $this->cartRepo->getTotal(2)
//            ])->withErrors($msgErros);
//        }
        //dd($request->input('courier_id'));


        // Get payment gateways
        $paymentGateways = collect(explode(',', config('payees.name')))->transform(function ($name) {
            return config($name);
        })->all();

        $billingAddress = $customer->addresses()->first();

        $courier = $this->courierRepo->findCourierById($request->input('courier_id'));
        //$shippingFee = $this->cartRepo->getShippingFee($courier);

        return view('front.checkout', [
            'customer' => $customer,
            'billingAddress' => $billingAddress,
            'addresses' => $customer->addresses()->get(),
            'products' => $this->cartRepo->getCartItems(),
            'subtotal' => $this->cartRepo->getSubTotal(),
            'tax' => $this->cartRepo->getTax(),
            'total' => $this->cartRepo->getTotal(2,$courier->cost),
            'payments' => $paymentGateways,
            'cartItems' => $this->cartRepo->getCartItemsTransformed(),
            'shipment_object_id' => $shipment_object_id,
            'courier'=>$courier
        ]);
    }

//    public function checkoutItens(CartDeliveryCheckoutRequest $request)
//    {
//
//     //  return $this->index($request);
//    }

    /**
     * Checkout the items
     *
     * @param CartCheckoutRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Shop\Addresses\Exceptions\AddressNotFoundException
     * @throws \App\Shop\Customers\Exceptions\CustomerPaymentChargingErrorException
     * @codeCoverageIgnore
     */
//    public function store(CartCheckoutRequest $request)
//    {
//        $shippingFee = 0;
//
//        switch ($request->input('payment')) {
//            case 'paypal':
//                return $this->payPal->process($shippingFee, $request);
//                break;
//            case 'stripe':
//
//                $details = [
//                    'description' => 'Stripe payment',
//                    'metadata' => $this->cartRepo->getCartItems()->all()
//                ];
//
//                $customer = $this->customerRepo->findCustomerById(auth()->id());
//                $customerRepo = new CustomerRepository($customer);
//                $customerRepo->charge($this->cartRepo->getTotal(2, $shippingFee), $details);
//                break;
//            default:
//        }
//    }


    public function store(CheckoutRequest $request)
    {
        $checkoutRepo = new CheckoutRepository;
        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $os = $orderStatusRepo->findByName('Pedido Feito');
        $courier = $this->courierRepo->findCourierById(intval(request()->get('courier_id')));

        if($request->input('payment_method') == config('pay-on-delivery.name'))
        {
            $os = $orderStatusRepo->findByName('Boleto Whatsapp');
        }else if($request->input('payment_method') == config('debit.name')){
            $os = $orderStatusRepo->findByName('Mercado Pago');
        }
//
        $order = $checkoutRepo->buildCheckoutItems([
            'reference' => Uuid::uuid4()->toString(),
            'courier_id' => $request->input('courier_id'),
            'customer_id' => $request->user()->id,
            'address_id' => $request->input('billingAddress_id'),
            'order_status_id' => $os->id,
            'payment' => $request->input('payment_method'),
            'discounts' => 0,
            'total_products' => $this->cartRepo->getSubTotal(),
            'total' => $this->cartRepo->getTotal(2, $courier->cost),
            'total_shipping' => $courier->cost,
            'total_paid' => 0,
            'tax' => $this->cartRepo->getTax(),
            'obs' =>$request->input('obs')
        ]);


        if($request->input('payment_method') == config('debit.name')){
            $preference = $this->callMercadoPago($order);

            Cart::destroy();

            return redirect()->to($preference['response']['init_point']);
        }

        Cart::destroy();





        return redirect()->route('accounts', ['tab' => 'orders'])->with('message', 'Pedido Cadastrado com Sucesso, Aguarde a aprovação do Pagamento');
    }

    /**
     * Execute the PayPal payment
     *
     * @param PayPalCheckoutExecutionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function executePayPalPayment(PayPalCheckoutExecutionRequest $request)
    {
        try {
            $this->payPal->execute($request);
            $this->cartRepo->clearCart();

            return redirect()->route('checkout.success');
        } catch (PayPalConnectionException $e) {
            throw new PaypalRequestError($e->getData());
        } catch (Exception $e) {
            throw new PaypalRequestError($e->getMessage());
        }
    }

    /**
     * @param StripeExecutionRequest $request
     * @return \Stripe\Charge
     */
    public function charge(StripeExecutionRequest $request)
    {
        try {
            $customer = $this->customerRepo->findCustomerById(auth()->id());
            $stripeRepo = new StripeRepository($customer);

            $stripeRepo->execute(
                $request->all(),
                Cart::total(),
                Cart::tax()
            );
            return redirect()->route('checkout.success')->with('message', 'Stripe payment successful!');
        } catch (StripeChargingErrorException $e) {
            Log::info($e->getMessage());
            return redirect()->route('checkout.index')->with('error', 'There is a problem processing your request.');
        }
    }

    /**
     * Cancel page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cancel(Request $request)
    {
        return view('front.checkout-cancel', ['data' => $request->all()]);
    }

    /**
     * Success page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view('front.checkout-success');
    }

    /**
     * @param Customer $customer
     * @param Collection $products
     *
     * @return mixed
     */
    private function createShippingProcess(Customer $customer, Collection $products)
    {
        $customerRepo = new CustomerRepository($customer);

        if ($customerRepo->findAddresses()->count() > 0 && $products->count() > 0) {

            $this->shippingRepo->setPickupAddress();
            $deliveryAddress = $customerRepo->findAddresses()->first();
            $this->shippingRepo->setDeliveryAddress($deliveryAddress);
            $this->shippingRepo->readyParcel($this->cartRepo->getCartItems());

            return $this->shippingRepo->readyShipment();
        }
    }

    public function neededBag()
    {
        $carItens = $this->cartRepo->getCartItemsTransformed();
        $hasBag = false;
        foreach($carItens as $carItem){
            if($carItem->name == 'Sacola Retornável'){
                $hasBag = true;

            }
        }

        if ((!is_null(auth()->user())) && auth()->user()->countBought() < 1 && !$hasBag) {

            $product = $this->productRepo->findByProductName('Sacola Retornável');
            $options = [];
            $this->cartRepo->addToCart($product,1,$options);
        }


    }

    public function callMercadoPago($order)
    {
        $this->cartRepo->getCartItems();
        $itens =[];
        $count=0;
        foreach ($this->cartRepo->getCartItems() as $item ) {

            $itens = array_add($itens,$count++ ,[
                'title' => $item->name,
                'quantity' => $item->qty,
                'currency_id' => 'BRL',
                'unit_price' => $item->price

            ]);
        }
        $itens= array_add($itens,$count++,[
            'title' => $order->courier->name,
            'quantity' => 1,
            'currency_id' => 'BRL',
            'unit_price' => floatval($order->total_shipping),
        ]);
//        dump($itens);
        $preference_data = array (
            ["items" => $itens,
                "payment_methods" => array(
                    "excluded_payment_types" => array(
                        array("id" => "ticket")
                    )),
                "external_reference" => $order->reference,]
        );

//        dump($preference_data);

        try {

            $mp = new MP(env('MP_APP_ID'), env('MP_APP_SECRET'));
            $preference = $mp->create_preference($preference_data);
            $order->mercado_pago_reference_id = $preference['response']['id'];
            $order->save();
            return $preference;
        } catch (Exception $e){
            dd($e);
        }
    }
}
