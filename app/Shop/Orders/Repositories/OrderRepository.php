<?php

namespace App\Shop\Orders\Repositories;

use App\Mail\SendFeedBackToAdminMailable;
use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Configurations\Configuration;
use App\Shop\Configurations\Repositories\ConfigurationRepository;
use App\Shop\FairFinancials\FairFinancial;
use App\Shop\FairFinancials\Repositories\FairFinancialRepository;
use App\Shop\Fairs\Fair;
use App\Shop\Fairs\Repositories\FairRepository;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Employees\Employee;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Events\OrderCreateEvent;
use App\Mail\sendEmailNotificationToAdminMailable;
use App\Mail\SendOrderToCustomerMailable;
use App\Shop\Orders\Exceptions\OrderInvalidArgumentException;
use App\Shop\Orders\Exceptions\OrderNotFoundException;
use App\Shop\Addresses\Address;
use App\Shop\Couriers\Courier;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\Orders\Transformers\OrderTransformable;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Integer;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    use OrderTransformable;

    /**
     * OrderRepository constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        parent::__construct($order);
        $this->model = $order;
    }

    /**
     * Create the order
     *
     * @param array $params
     * @return Order
     * @throws OrderInvalidArgumentException
     */
    public function createOrder(array $params): Order
    {
        try {
            $order = $this->create($params);

            $orderRepo = new OrderRepository($order);
            $orderRepo->buildOrderDetails(Cart::content());

            event(new OrderCreateEvent($order));

            return $order;
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * @param array $params
     *
     * @return bool
     * @throws OrderInvalidArgumentException
     */
    public function updateOrder(array $params): bool
    {
        try {
            return $this->update($params);
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Order
     * @throws OrderNotFoundException
     */
    public function findOrderById(int $id): Order
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new OrderNotFoundException($e);
        }
    }

    /**
     * Return all the orders
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listOrders(
        string $order = 'id',
        string $sort = 'desc',
        array $columns = ['*']
    ): Collection {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function findProducts(Order $order): Collection
    {
        return $order->products;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param array $data
     */
    public function associateProduct(
        Product $product,
        int $quantity = 1,
        array $data = []
    ) {
        $this->model->products()->attach($product, [
            'quantity' => $quantity,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'product_description' => $product->description,
            'product_price' => $product->price,
            'product_attribute_id' => isset($data['product_attribute_id'])
                ? $data['product_attribute_id']
                : null,
        ]);
        $product->quantity = $product->quantity - $quantity;
        $product->save();
    }

    /**
     * Send email to customer
     */
    public function sendEmailToCustomer()
    {
        Mail::to($this->model->customer)->send(
            new SendOrderToCustomerMailable(
                $this->findOrderById($this->model->id)
            )
        );
    }

    /**
     * Send email notification to the admin
     */
    public function sendEmailNotificationToAdmin()
    {
        $configRepo = new ConfigurationRepository(new Configuration());
        $config = $configRepo->getConfig();
        if ($config->send_email_on_buy_products) {
            $employeeRepo = new EmployeeRepository(new Employee());
            $employees = $employeeRepo->findEmployeesByRole(1);

            foreach ($employees as $employee) {
                Mail::to($employee)->send(
                    new sendEmailNotificationToAdminMailable(
                        $this->findOrderById($this->model->id),
                        $employee
                    )
                );
            }
        }
    }

    public function sendFeedBackToAdminMailable($user, $comment){

        $employeeRepo = new EmployeeRepository(new Employee());
        $employees = $employeeRepo->findEmployeesByRole(1);

        foreach ($employees as $employee) {
            Mail::to($employee)->send(
                new SendFeedBackToAdminMailable(
                    $user,$comment,
                    $employee
                )
            );
        }
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchOrder(string $text): Collection
    {
        if (!empty($text)) {
            return $this->model->searchForOrder($text)->get();
        } else {
            return $this->listOrders();
        }
    }

    /**
     * @return Order
     */
    public function transform()
    {
        return $this->transformOrder($this->model);
    }

    /**
     * @return Collection
     */
    public function listOrderedProducts(): Collection
    {
        return $this->model->products->map(function (Product $product) {
            $product->name = $product->pivot->product_name;
            $product->sku = $product->pivot->product_sku;
            $product->description = $product->pivot->product_description;
            $product->price = $product->pivot->product_price;
            $product->quantity = $product->pivot->quantity;
            $product->product_attribute_id =
                $product->pivot->product_attribute_id;
            return $product;
        });
    }

    /**
     * @param Collection $items
     */
    public function buildOrderDetails(Collection $items)
    {
        $items->each(function ($item) {
            $productRepo = new ProductRepository(new Product());
            $product = $productRepo->find($item->id);
            if ($item->options->has('product_attribute_id')) {
                $this->associateProduct($product, $item->qty, [
                    'product_attribute_id' =>
                        $item->options->product_attribute_id,
                ]);
            } else {
                $this->associateProduct($product, $item->qty);
            }
        });
    }

    /**
     * @return Collection $addresses
     */
    public function getAddresses(): Collection
    {
        return $this->model->address()->get();
    }

    /**
     * @return Collection $couriers
     */
    public function getCouriers(): Collection
    {
        return $this->model->courier()->get();
    }

    public function totalOrders($fair_id)
    {
        return $this->model
            ->where('fair_id', $fair_id)
            ->whereNotIn('order_status_id', [
                env('ORDER_ERROR'),
                env('ORDER_CANCELED'),
            ])
            ->count();
    }

    public function totalShipping($fair_id)
    {
        return $this->model
            ->where('fair_id', $fair_id)
            ->whereNotIn('order_status_id', [
                env('ORDER_ERROR'),
                env('ORDER_CANCELED'),
            ])
            ->sum('total_shipping');
    }

    public function totalProducts($fair_id)
    {
        return $this->model
            ->where('fair_id', $fair_id)
            ->whereNotIn('order_status_id', [
                env('ORDER_ERROR'),
                env('ORDER_CANCELED'),
            ])
            ->sum('total_products');
    }

    public function totalAmount($fair_id)
    {
        return $this->model
            ->where('fair_id', $fair_id)
            ->whereNotIn('order_status_id', [
                env('ORDER_ERROR'),
                env('ORDER_CANCELED'),
            ])
            ->sum('total');
    }

    public function findByFairId($fair_id)
    {
        return $this->model->where('fair_id', $fair_id)->get();
    }

    public function markAsPayed($id, $orderStatus)
    {
        $order = $this->findOrderById((int) $id);
        $order->order_status_id = $orderStatus->id;
        $order->total_paid = $order->total;

        $order->save();

        return $order;
    }

    public function cancelOrder($order_id)
    {
        $order = $this->findOrderById($order_id);
        $order->order_status_id = env('ORDER_CANCELED');
        return $order->save();
    }

    public function updateProducts(Request $request, $orderId)
    {
        $order = $this->findOrderById($orderId);

        $productRepo = new ProductRepository(new Product());

        $product = $productRepo->find(
            $request->get('product_id')
        );
        $qtd = $request->get('quantity');
        $newProduct = true;

        foreach ($order->products()->get() as $item) {
            if ($product->id == $item->id) {


                $order
                    ->products()
                    ->updateExistingPivot($item, ['quantity' => $qtd + $item->pivot->quantity], false);

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

        $product = $productRepo->findProductById($request->get('product_id'));
//        dump($product->quantity);
        $product->quantity = $product->quantity - $qtd;
//        dd($product->quantity);
        $productR = new ProductRepository($product);
        $productR->updateProduct($product->toArray());
//        $productRepo->updateProduct($product->toArray());

        $this->refreshTotal($order);
    }

    public function refreshTotal(Order $order)
    {
        $fairRepo = new FairFinancialRepository(new FairFinancial());
        $total = 0.0;
        foreach ($order->products()->get() as $item) {
            $total += $item->pivot->quantity * $item->pivot->product_price;
        }
        $order->total_products = $total;
        $order->total = $order->total_products + $order->total_shipping;
        $order->save();
        //        dd($total);
        $fairRepo->refreshFairFinancial($order->fair_id);
    }

}
