<?php

namespace App\Http\Controllers\Front;

use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\Orders\Transformers\OrderTransformable;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    use OrderTransformable;

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
        OrderRepository $orderRepository
    ) {
        $this->customerRepo = $customerRepository;
        $this->courierRepo = $courierRepository;
        $this->orderRepo = $orderRepository;
    }

    public function index()
    {
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        $customerRepo = new CustomerRepository($customer);

        $addresses = $customerRepo->findAddresses();


        return view('front.accounts', [
            'customer' => $customer,
            'addresses' => $addresses
        ]);
    }

    public function orders()
    {
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        $customerRepo = new CustomerRepository($customer);
        $orders = $customerRepo->findOrders(['*'], 'created_at');

        $orders->transform(function (Order $order) {
            return $this->transformOrder($order);
        });

        $orders->load('products');


        return view('front.orders', [
            'orders' => $this->customerRepo->paginateArrayResults($orders->toArray(), 15),
        ]);
    }

    public function addresses()
    {
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        $customerRepo = new CustomerRepository($customer);

        $addresses = $customerRepo->findAddresses();

        return view('front.addresses', [
            'addresses' => $addresses
        ]);
    }

    public function cancelOrder(Request $request)
    {
        $order = $this->orderRepo->findOrderById($request->input('order_id'));
        $order->order_status_id = env('ORDER_CANCELED');
        $order->save();
        $request->session()->flash('message','Pedido Cancelado');

        return redirect()->back();

    }
}
