<?php

namespace App\Http\Controllers\Front;

use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\Orders\Transformers\OrderTransformable;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Transformations\ProductTransformable;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    use OrderTransformable, ProductTransformable;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    private $orderRepo;
    /**
     * AccountsController constructor.
     *
     * @param CourierRepositoryInterface $courierRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        CourierRepositoryInterface $courierRepository,
        CustomerRepositoryInterface $customerRepository,
        ProductRepositoryInterface $productRepository,
        OrderRepository $orderRepository
    ) {
        $this->customerRepo = $customerRepository;
        $this->courierRepo = $courierRepository;
        $this->orderRepo = $orderRepository;
        $this->productRepo = $productRepository;
    }

    public function index()
    {
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        $customerRepo = new CustomerRepository($customer);

        $addresses = $customerRepo->findAddresses();

        return view('front.accounts', [
            'customer' => $customer,
            'addresses' => $addresses,
        ]);
    }

    public function orders()
    {
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        $list = $this->productRepo->listProducts('name','asc');

        $products = $list->where('status', 1)->where('quantity','>',0)->
        map(function (Product $item) {
            return $this->transformProduct($item);
        });

        $customerRepo = new CustomerRepository($customer);
        $orders = $customerRepo->findOrders(['*'], 'created_at');

        $orders->transform(function (Order $order) {
            return $this->transformOrder($order);
        });

        $orders->load('products');

        return view('front.orders', [
            'orders' => $this->customerRepo->paginateArrayResults(
                $orders->toArray(),
                15
            ),
        'products'=>$products]);
    }

    public function addresses()
    {
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        $customerRepo = new CustomerRepository($customer);

        $addresses = $customerRepo->findAddresses();

        return view('front.addresses', [
            'addresses' => $addresses,
        ]);
    }

    public function cancelOrder(Request $request)
    {
        $this->orderRepo->cancelOrder($request->input('order_id'));
        $request->session()->flash('message', 'Pedido Cancelado');

        return redirect()->back();
    }

    public function notices()
    {
        return view('front.shared.notices');
    }

    public function sendFeedback(Request $request){

        $this->orderRepo->sendFeedBackToAdminMailable(auth()->user(), $request->get('comentario'));

        return redirect()->route('orders')->with('message', 'Agradecemos pelo(s) comentário(s)! Obrigado por ajudar a cesta a melhorar!');

    }

}
