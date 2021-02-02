<?php

namespace App\Http\Controllers\Admin\Fairs;

use App\Exports\FinancialExport;
use App\Exports\HarverstExport;
use App\Exports\HarverstPaymentExport;
use App\Exports\ProducerHarverstExport;
use App\Exports\OrdersDetailExport;
use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Addresses\Transformations\AddressTransformable;
use App\Shop\Couriers\Courier;
use App\Shop\Couriers\Repositories\CourierRepository;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Fair\Requests\CreateFairRequest;
use App\Shop\FairFinancials\FairFinancial;
use App\Shop\FairFinancials\Repositories\FairFinancialRepository;
use App\Shop\Orders\Order;
use App\Shop\Fairs\Repositories\FairRepository;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Http\Controllers\Controller;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class FairController extends Controller
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

    private $fairRepo;

    private $fairFinancialRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CourierRepositoryInterface $courierRepository,
        CustomerRepositoryInterface $customerRepository,
        OrderStatusRepositoryInterface $orderStatusRepository,
        ProductRepository $productRepository,
        FairRepository $fairRepository,
        FairFinancialRepository $fairFinancialRepository
    ) {
        $this->orderRepo = $orderRepository;
        $this->courierRepo = $courierRepository;
        $this->customerRepo = $customerRepository;
        $this->orderStatusRepo = $orderStatusRepository;
        $this->productRepo = $productRepository;
        $this->fairRepo = $fairRepository;
        $this->fairFinancialRepo = $fairFinancialRepository;

        $this->middleware(['permission:update-order, guard:employee'], ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.fairs.list', ['fairs' => $this->fairRepo->all()->sortByDesc('id')]);
    }

    public function create()
    {
        return view ('admin.fairs.create');
    }

    public function show($fair_id)
    {
        $fair = $this->fairRepo->find($fair_id);


        return view('admin.fairs.edit')->with('fair',$fair);

    }

//    public function store(Request $request){
//
//        $this->fairRepo->create($request->toArray());
//
//        return view('admin.fairs.list', ['fairs' => $this->fairRepo->all()])->with('message',$this->getSucessMesseger());
//    }

    public function store(Request $request){

        if(is_null($request->input('id'))){
            $this->fairRepo->create($request->toArray());
        }else{
            $fair = $this->fairRepo->findFairById($request->input('id'));

            $update = new FairRepository($fair);

            $update->update($request->all());
        }

        return redirect()->route('admin.fairs.index')->with('fairs',$this->fairRepo->all())->with('message',$this->getSucessMesseger());
    }

    public function showOrders($fair_id)
    {
        $list = $this->orderRepo->listOrders('created_at', 'desc')->where('fair_id','=',$fair_id);

        $orders = $this->orderRepo->paginateArrayResults($this->transFormOrder($list), 10);

        return view('admin.orders.list', ['orders' => $orders,
                                                'fair_id'=>$fair_id]);
    }

    public function showHarvest($fair_id)
    {
//        $harvest = $this->fairRepo->harvest($fair_id);

//        $data = ['harvest'=>$harvest];

//        $pdf = app()->make('dompdf.wrapper');
//        $pdf->loadView('invoices.harvest', $data)->stream();

//        return $pdf->stream();
//        return view('invoices.harvest', $data);
        return Excel::download(new HarverstExport($this->fairRepo,$this->orderRepo,$fair_id),'colheita.xlsx');
    }

    public function showHarvestProducer($fair_id)
    {
        return Excel::download(new ProducerHarverstExport($this->fairRepo,$this->orderRepo,$this->productRepo,$fair_id),'colheita.xlsx');
    }

    public function generateLabel($fair_id)   {

        $orders = app(Order::class)->where('fair_id','=',$fair_id)->whereNotIn('order_status_id',[env('ORDER_ERROR'),env('ORDER_CANCELED')])->get();
        $data = ['orders'=>$orders];
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('invoices.labels', $data)->stream();

        return $pdf->stream();

//        return view('invoices.labels', $data);
//         return view('admin.orders.labels')->with('orders',$this->transFormOrder($orders));
    }

    public function getOrderPending($fair_id){
        $list = app(Order::class)->where('fair_id','=',$fair_id)->whereNotIn('order_status_id',[1,4,7])->get();

        $orders = $this->orderRepo->paginateArrayResults($this->transFormOrder($list), 10);
        return view('admin.orders.list', ['orders' => $orders,
            'fair_id'=>$fair_id]);

    }

    public function generateDeliveryList($fair_id)
    {
        $deliveryAddrresses = $this->fairRepo->deliveryAddresses($fair_id);
        $fair = $this->fairRepo->find($fair_id);

        $data = ['deliveryAddrresses'=>$deliveryAddrresses];
        $data = array_merge($data,['fair'=>$fair]);

//        dd($data);
//
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('invoices.delivery', $data)->stream();
//
        return $pdf->stream();
                return view('invoices.delivery', $data);

    }

    public function createFairFinancial($fair_id){




//    dump($harvest);
        $fair = $this->fairRepo->findFairById($fair_id);

//        if($fair->fairFinancials()->count() == 0){

            $this->fairFinancialRepo->refreshFairFinancial($fair_id);

            return redirect()->route('admin.fair.financial',$fair->id);
//        }else{
//            return redirect()->route('admin.fair.financial',$fair->id)->withErrors('O Extrato já foi gerado.');
//        }

    }

    public function financial($fair_id)
    {
        $fair = $this->fairRepo->find($fair_id);
//        dd($fair->fairFinancials()->get()[0]->totalProducers());

        $data[] = null;
         $data = ['financial'=>$this->fairRepo->getExtract($fair_id)];
         $data = array_merge($data,['productors'=>$this->fairRepo->getHarverstPayment($fair_id)]);
         $data = array_merge($data,['fair'=>$fair]);
         $data = array_merge($data,['fairFinancial']);
         $data = array_merge($data,['totalOrders'=>$this->orderRepo->totalOrders($fair_id)]);
        $data = array_merge($data,['totalAmount'=>$this->orderRepo->totalAmount($fair_id)]);



         return view('admin.fairs.financial', $data);
    }

    public function detailReport($fair_id)
    {
        $orders = $this->orderRepo->findByFairId($fair_id);

        return view('admin.fairs.report-details')
            ->with('orders',$orders)
            ->with('fair',$this->fairRepo->find($fair_id));
    }

    public function exportFair($fair_id){
//        $this->fairRepo->getExtract($fair_id);

        return (new FinancialExport($this->fairRepo,$this->orderRepo,$fair_id))->download('extrato_feira.xlsx');
//        return Excel::download(new FinancialExport($this->fairRepo,$this->orderRepo,$fair_id), 'extrato_feira.xlsx');
    }

    public function exportHarverstPayment($fair_id){
//        $this->fairRepo->getExtract($fair_id);

        return (new HarverstPaymentExport($this->fairRepo,$this->orderRepo,$fair_id))->download('produtos_vendidos.xlsx');
//        return Excel::download(new FinancialExport($this->fairRepo,$this->orderRepo,$fair_id), 'extrato_feira.xlsx');
    }

    public function exportFairsOrders($fair_id){
        return (new OrdersDetailExport($this->fairRepo,$this->orderRepo,$fair_id))->download('pedidos_feira.xlsx');
    }

    public function markAllAssPayed($fair_id)
    {
        $orders = $this->orderRepo->findByFairId($fair_id);

        $orderStatus = $this->orderStatusRepo->findByName('Pago');
        foreach ($orders as $order) {
            if($order->order_status_id != env('ORDER_CANCELED') &&
                $order->order_status_id != env('ORDER_ERROR'))
            $this->orderRepo->markAsPayed($order->id,$orderStatus);
        }

        request()->session()->flash('message',$this->getSucessMesseger());
        return redirect()->route('admin.dashboard');
    }

    /**
     * @param Collection $list
     * @return array
     */
    private function transFormOrder(Collection $list)
    {
        $courierRepo = new CourierRepository(new Courier());
        $customerRepo = new CustomerRepository(new Customer());
        $orderStatusRepo = new OrderStatusRepository(new OrderStatus());

        return $list->transform(function (Order $order) use ($courierRepo, $customerRepo, $orderStatusRepo) {
            $order->courier = $courierRepo->findCourierById($order->courier_id);
            $order->customer = $customerRepo->findCustomerById($order->customer_id);
            $order->status = $orderStatusRepo->findOrderStatusById($order->order_status_id);
            return $order;
        })->all();
    }
}
