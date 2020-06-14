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
use Illuminate\Support\Facades\Redirect;
use PayPal\Exception\PayPalConnectionException;
use Ramsey\Uuid\Uuid;

class CheckoutController extends Controller
{
    use ProductTransformable;

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
        $customer = $request->user();
        $billingAddress = $customer->addresses()->first();


        if(env('PAGSEGURO_OPEN')){

           $courier = $this->courierRepo->findCourierById($request->input('courier_id'));
           $order = $this->createOrder($courier,$customer,$billingAddress,$request->input('obs'));
           $pagseguroCode = $this->getDataPagSeguro($this->cartRepo->getCartItemsTransformed(),
           $courier,$customer, $billingAddress, $order);
           Cart::destroy();
           return Redirect::to(env('URL_PAGSEGURO_PAYMENT').'?code='.$pagseguroCode);

       }else{

            return $this->checkoutSite($request);

        }
    }


    public function createOrder($courier,$customer,$billingAddress,$obs)
    {
        $checkoutRepo = new CheckoutRepository;
        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $os = $orderStatusRepo->findByName('Pedido Feito');

        $order = $checkoutRepo->buildCheckoutItems([
            'reference' => Uuid::uuid4()->toString(),
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $billingAddress->id,
            'order_status_id' => $os->id,
            'payment' => 'pagSeguro',
            'discounts' => 0,
            'total_products' => $this->cartRepo->getSubTotal(),
            'total' => $this->cartRepo->getTotal(2, $courier->cost),
            'total_shipping' => $courier->cost,
            'total_paid' => 0,
            'tax' => $this->cartRepo->getTax(),
            'obs' => $obs
        ]);

        return $order;
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


    public function reprocessPagSeguro(Request $request)
    {
        if($request->has('order_id')){
            $order = $this->orderRepo->find($request->get('order_id'));

            $data = $this->preparedata();
            $count = 1;
            foreach($order->products as $product){
                $data['itemId'.$count] = $product->sku;
                $data['itemDescription'.$count] = $product->name;
                //     $data['produto'] = "";
                $data['itemAmount'.$count] = number_format($product->pivot->product_price,2);
                $data['itemQuantity'.$count] = $product->pivot->quantity;
                $data['itemWeight'.$count] = "0";
                $count++;
            }
            $data = $this->feedData($order,$order->customer,$order->address,$order->courier,$data);
            //dd($data);
            $pagseguroCode = $this->callCurl($data);
            return Redirect::to(env('URL_PAGSEGURO_PAYMENT').'?code='.$pagseguroCode);
        }
    }

    public function getDataPagSeguro($cartitems, $courier,$customer, $billingAddress,$order){
         $data = $this->preparedata();


         $count = 1;

         foreach($cartitems as $item){
             $data['itemId'.$count] = $item->product->sku;
             $data['itemDescription'.$count] = $item->name;
    //     $data['produto'] = "";
             $data['itemAmount'.$count] = number_format($item->price,2);
             $data['itemQuantity'.$count] = $item->qty;
             $data['itemWeight'.$count] = "0";
             $count++;
         }
        $data = $this->feedData($order,$customer,$billingAddress,$courier,$data);
        return $this->callCurl($data);
    }

    public function feedData($order,$customer,$billingAddress,$courier,$data){
        
        $data['reference'] = $order->reference;
        $data['senderName'] = $customer->name;
        $data['senderAreaCode'] = "37";
        $data['senderphone'] = $billingAddress->phone;
        $data['senderEmail'] = $customer->email;

        $data['shippingType'] = "3";
        $data['shippingCost'] = $courier->cost;
        if(!$courier->is_pick_up_location){
            $data['shippingAddressStreet'] = $billingAddress->address_1;
            //$data['shippingAddressNumber'] = ;
            $data['shippingAddressComplement'] = $billingAddress->address_2;
            $data['shippingAddressDistrict'] = $billingAddress->neighborhoods;
            $data['shippingAddressPostalCode'] = $billingAddress->zip;
        }else{
            //$data['shippingAddressStreet'] = $courier->name;
            $data['shippingAddressPostalCode'] =$courier->cep;
            $data['shippingAddressComplement'] = 'PONTO DE RETIRADA';
            $data['shippingAddressNumber'] = $courier->number;



        }
        $data['shippingAddressCity'] = "Rio de Janeiro";
        $data['shippingAddressState'] = "RJ";
        $data['shippingAddressContry'] = "ATA";

        return $data;
    }

    public function preparedata(){

        $data = [];
        $data['email'] = env('PAGSEGURO_EMAIL');
        $data['token'] = env('PAGSEGURO_TOKEN');
        $data['currency'] = "BRL";

        return $data;
    }

    public function callCurl($data)
    {
        $buildQuery = http_build_query($data);
        $url = env('URL_PAGSEGURO_CHECKOUT');
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1'));
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$buildQuery);

        $return = curl_exec($curl);
        curl_close($curl);
        $xml = simplexml_load_string($return);

        return $xml->code;
    }

    public function store(CheckoutRequest $request)
    {
        $checkoutRepo = new CheckoutRepository;
        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $os = $orderStatusRepo->findByName('Pedido Feito');
        $courier = $this->courierRepo->findCourierById(intval(request()->get('courier_id')));

        if($request->input('payment_method') == config('pay-on-delivery.name')
        ||$request->input('payment_method') == config('debit.name')){
            $os = $orderStatusRepo->findByName('Pagar na Entrega');
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
        return redirect()->route('accounts', ['tab' => 'orders'])->with('message', 'Pedido Cadastrado com Sucesso, Aguarde a aprovação do Pagamento');
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

    public function checkoutSite($request){

        $this->neededBag();

        $carItens = $this->cartRepo->getCartItems();
        $customer = $request->user();
        $rates = null;
        $shipment_object_id = null;

        $error = false;
        $msgErros = [];

        foreach($carItens as $carItem){
            if($carItem->qty >$carItem->product->quantity){
                $error = true;
                $msg = ['O produto "'. $carItem->name . '" possui '. $carItem->product->quantity . ' no estoque. Por favor, atualize o seu pedido'];
                $msgErros = array_merge($msgErros,$msg);
            }
        }

        if($error){


            $couriers = $this->courierRepo->allEnable();

            return view('front.carts.cart', [
                'cartItems' => $this->cartRepo->getCartItemsTransformed(),
                'subtotal' => $this->cartRepo->getSubTotal(),
                'tax' => $this->cartRepo->getTax(),
                'couriers' => $couriers,
                'total' => $this->cartRepo->getTotal(2)
            ])->withErrors($msgErros);
        }



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


}
