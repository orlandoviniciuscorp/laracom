<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Addresses\Transformations\AddressTransformable;
use App\Shop\Couriers\Courier;
use App\Shop\Couriers\Repositories\CourierRepository;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\FairFinancials\FairFinancial;
use App\Shop\FairFinancials\Repositories\FairFinancialRepository;
use App\Shop\Fairs\Fair;
use App\Shop\Fairs\Repositories\FairRepository;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Http\Controllers\Controller;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    use AddressTransformable;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * @var OrderStatusRepositoryInterface
     */
    private $orderStatusRepo;

    private $fairFinancialRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CourierRepositoryInterface $courierRepository,
        CustomerRepositoryInterface $customerRepository,
        OrderStatusRepositoryInterface $orderStatusRepository,
        ProductRepository $productRepository,
        FairFinancialRepository $fairFinancialRepo
    ) {
        $this->orderRepo = $orderRepository;
        $this->courierRepo = $courierRepository;
        $this->customerRepo = $customerRepository;
        $this->orderStatusRepo = $orderStatusRepository;
        $this->productRepo = $productRepository;
        $this->fairFinancialRepo = $fairFinancialRepo;

        $this->middleware(
            ['permission:update-order, guard:employee'],
            ['only' => ['edit', 'update']]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->orderRepo->listOrders('created_at', 'desc');
        $data = [];
        if (request()->has('q')) {
            if (request()->has('fair_id')) {
                $list = $this->orderRepo
                    ->searchOrder(request()->input('q') ?? '')
                    ->where('fair_id', '=', request()->input('fair_id'));
                $data = array_merge($data, [
                    'fair_id' => request()->input('fair_id'),
                ]);
            } else {
                $list = $this->orderRepo->searchOrder(
                    request()->input('q') ?? ''
                );
            }
        }

        $orders = $this->orderRepo->paginateArrayResults(
            $this->transFormOrder($list),
            10
        );
        $data = array_merge($data, ['orders' => $orders]);
        //dd($data);

        return view('admin.orders.list', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $orderId
     * @return \Illuminate\Http\Response
     */
    public function show($orderId)
    {
        $order = $this->orderRepo->findOrderById($orderId);

        $orderRepo = new OrderRepository($order);
        $order->courier = $orderRepo->getCouriers()->first();
        $order->address = $orderRepo->getAddresses()->first();
        $items = $orderRepo->listOrderedProducts();

        return view('admin.orders.show', [
            'order' => $order,
            'items' => $items,
            'customer' => $this->customerRepo->findCustomerById(
                $order->customer_id
            ),
            'currentStatus' => $this->orderStatusRepo->findOrderStatusById(
                $order->order_status_id
            ),
            'payment' => $order->payment,
            'user' => auth()
                ->guard('employee')
                ->user(),
        ]);
    }

    /**
     * @param $orderId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($orderId)
    {
        $order = $this->orderRepo->findOrderById($orderId);

        $orderRepo = new OrderRepository($order);
        $order->courier = $orderRepo->getCouriers()->first();
        $order->address = $orderRepo->getAddresses()->first();
        $items = $orderRepo->listOrderedProducts();
        $products = $this->productRepo->listProducts('name', 'asc');

        return view('admin.orders.edit', [
            'statuses' => $this->orderStatusRepo->listOrderStatuses(),
            'order' => $order,
            'items' => $items,
            'customer' => $this->customerRepo->findCustomerById(
                $order->customer_id
            ),
            'currentStatus' => $this->orderStatusRepo->findOrderStatusById(
                $order->order_status_id
            ),
            'payment' => $order->payment,
            'user' => auth()
                ->guard('employee')
                ->user(),
            'products' => $products,
        ]);
    }

    public function updateProducts(Request $request, $orderId)
    {
        $order = $this->orderRepo->findOrderById($orderId);

        $roles = auth()
            ->guard('employee')
            ->user()
            ->roles()
            ->first();
        if ($roles->name != 'superadmin') {
            //$request->session()->flash('message', $this->getSucessMesseger());
            return redirect()
                ->route('admin.orders.edit', $order->id)
                ->withErrors('Somente Administradores podem Alterar pedidos');
        }

        $product = $this->productRepo->findProductById(
            $request->get('product_id')
        );
        $qtd = $request->get('quantity');
        $newProduct = true;

        foreach ($order->products()->get() as $item) {
            if ($product->id == $item->id) {
                $qtd = $qtd + $item->pivot->quantity;
                $product->quantity = $product->quantity - $qtd;
                //                dd($qtd);
                $order
                    ->products()
                    ->updateExistingPivot($item, ['quantity' => $qtd], false);
                $product->update();
                $newProduct = false;
            }
        }

        if ($newProduct) {
            $order->products()->attach($product, [
                'quantity' => $qtd,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'product_description' => $product->description,
                'product_price' => $product->price,
                'product_attribute_id' => null,
            ]);
        }

        $this->refreshTotal($order);

        $request->session()->flash('message', $this->getSucessMesseger());
        return redirect()->route('admin.orders.edit', $order->id);
    }

    public function removeProducts(Request $request, $orderId)
    {
        $order = $this->orderRepo->findOrderById($orderId);

        $roles = auth()
            ->guard('employee')
            ->user()
            ->roles()
            ->first();
        if ($roles->name != 'superadmin') {
            //$request->session()->flash('message', $this->getSucessMesseger());
            return redirect()
                ->route('admin.orders.edit', $order->id)
                ->withErrors('Somente Administradores podem Alterar pedidos');
        }

        $order->products()->detach($request->get('selected_ids'));

        $this->refreshTotal($order);

        $request->session()->flash('message', $this->getSucessMesseger());
        return redirect()->route('admin.orders.edit', $order->id);
    }

    /**
     * @param Request $request
     * @param $orderId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $orderId)
    {
        $order = $this->orderRepo->findOrderById($orderId);
        $orderRepo = new OrderRepository($order);

        if (
            $request->has('total_paid') &&
            $request->input('total_paid') != null
        ) {
            $orderData = $request->except('_method', '_token');
        } else {
            $orderData = $request->except('_method', '_token', 'total_paid');
        }

        $orderRepo->updateOrder($orderData);
        $request->session()->flash('message', $this->getSucessMesseger());
        return redirect()->route('admin.fair.orders-list', $order->fair_id);
    }

    /**
     * Generate order invoice
     *
     * @param int $id
     * @return mixed
     */
    public function generateInvoice(int $id)
    {
        $order = $this->orderRepo->findOrderById($id);

        $data = [
            'order' => $order,
            'products' => $order->products,
            'customer' => $order->customer,
            'courier' => $order->courier,
            'address' => $this->transformAddress($order->address),
            'status' => $order->orderStatus,
            'payment' => $order->paymentMethod,
        ];

        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('invoices.orders', $data)->stream();
        return $pdf->stream();
    }

    /**
     * @param Collection $list
     * @return array
     */
    protected function transFormOrder(Collection $list)
    {
        $courierRepo = new CourierRepository(new Courier());
        $customerRepo = new CustomerRepository(new Customer());
        $orderStatusRepo = new OrderStatusRepository(new OrderStatus());
        $fairRepo = new FairRepository(new Fair());

        return $list
            ->transform(function (Order $order) use (
                $courierRepo,
                $customerRepo,
                $orderStatusRepo,
                $fairRepo
            ) {
                $order->courier = $courierRepo->findCourierById(
                    $order->courier_id
                );
                $order->customer = $customerRepo->findCustomerById(
                    $order->customer_id
                );
                $order->status = $orderStatusRepo->findOrderStatusById(
                    $order->order_status_id
                );
                $order->fair = $fairRepo->findFairById($order->fair_id);
                return $order;
            })
            ->all();
    }

    public function markAsPayed($id)
    {
        $orderStatus = $this->orderStatusRepo->findByName('Pago');

        $order = $this->orderRepo->markAsPayed($id, $orderStatus);

        request()
            ->session()
            ->flash('message', $this->getSucessMesseger());
        return redirect()->route('admin.fair.orders-list', $order->fair_id);
    }

    private function refreshTotal(Order $order)
    {
        $total = 0.0;
        foreach ($order->products()->get() as $item) {
            $total += $item->pivot->quantity * $item->pivot->product_price;
        }
        $order->total_products = $total;
        $order->total = $order->total_products + $order->total_shipping;
        $order->save();
        //        dd($total);

        $this->fairFinancialRepo->refreshFairFinancial($order->fair_id);
    }
}
