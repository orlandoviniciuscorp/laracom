<?php

namespace App\Shop\Fairs\Repositories;

use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Fairs\Fair;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
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

class FairRepository extends BaseRepository
{
    use OrderTransformable;

    /**
     * OrderRepository constructor.
     * @param Order $order
     */
    public function __construct(Fair $fair)
    {
        parent::__construct($fair);
        $this->model = $fair;
    }

    /**
     * Create the order
     *
     * @param array $params
     * @return Order
     * @throws OrderInvalidArgumentException
     */
    public function createOrder(array $params) : Order
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
     * @param int $id
     * @return Order
     * @throws OrderNotFoundException
     */
    public function findFairById(int $id) : Fair
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new FairNotFoundException($e);
        }
    }

    public function findLastFair(){

        return $this->model->max('id');
    }


    /**
     * Return all the orders
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listOrders(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }




    /**
     * @param Product $product
     * @param int $quantity
     * @param array $data
     */
    public function associateProduct(Product $product, int $quantity = 1, array $data = [])
    {
        $this->model->products()->attach($product, [
            'quantity' => $quantity,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'product_description' => $product->description,
            'product_price' => $product->price,
            'product_attribute_id' => isset($data['product_attribute_id']) ? $data['product_attribute_id']: null,
        ]);
        $product->quantity = ($product->quantity - $quantity);
        $product->save();
    }

    /**
     * Send email to customer
     */
    public function sendEmailToCustomer()
    {
        Mail::to($this->model->customer)
            ->send(new SendOrderToCustomerMailable($this->findOrderById($this->model->id)));
    }

    /**
     * Send email notification to the admin
     */
    public function sendEmailNotificationToAdmin()
    {
        $employeeRepo = new EmployeeRepository(new Employee);
        $employee = $employeeRepo->findEmployeeById(1);

        Mail::to($employee)
            ->send(new sendEmailNotificationToAdminMailable($this->findOrderById($this->model->id)));
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchOrder(string $text) : Collection
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
    public function listOrderedProducts() : Collection
    {
        return $this->model->products->map(function (Product $product) {
            $product->name = $product->pivot->product_name;
            $product->sku = $product->pivot->product_sku;
            $product->description = $product->pivot->product_description;
            $product->price = $product->pivot->product_price;
            $product->quantity = $product->pivot->quantity;
            $product->product_attribute_id = $product->pivot->product_attribute_id;
            return $product;
        });
    }

    public function harvest($id)
    {
        return DB::select('select c.name as produtor, p.name as produto, sum(op.quantity) as quantidade '.
                ' from orders o, ' .
                '	 order_product op, ' .
                '	 products p, ' .
                '     category_product cp, ' .
                '     categories c ' .
                'where o.fair_id = ? and o.order_status_id not in (3,6) ' .
                'and o.id = op.order_id and p.id = op.product_id ' .
                'and cp.category_id = c.id and cp.product_id = p.id ' .
                'group by c.name, p.name', [$id]);
    }

    public function deliveryAddresses($fair_id){

        return DB::select(' select 																' .
            ' o.id as pedido,                                                       ' .
            ' c.name as cliente,                                                    ' .
            ' c.email as email,                                                     ' .
            ' ad.phone as telefone,                                                 ' .
            ' o.payment as pagamento,                                               ' .
            ' o.total as total,                                                     ' .
            ' co.name as zona,                                                      ' .
            ' sum(op.quantity) as itens,	                                        ' .
            ' ad.address_1 as end_1, 												' .
            ' ad.address_2 as end_2,              									' .
            ' o.obs as observacao                                                   ' .
            ' from orders o,                                                        ' .
            ' 	 customers c,                                                       ' .
            '      order_product op,                                                ' .
            '      addresses ad,                                                    ' .
            '      products p,                                                      ' .
            '      couriers co                                                      ' .
            ' where                                                                 ' .
            ' o.fair_id = ?                                                         ' .
            ' and co.id = o.courier_id                                              ' .
            ' and o.customer_id = c.id                                              ' .
            ' and op.order_id = o.id                                                ' .
            ' and o.address_id = ad.id                                              ' .
            ' and op.product_id = p.id                                              ' .
            ' and o.order_status_id not in(3,6)                                     ' .
            ' group by o.id,c.name, c.email, ad.phone, o.payment, o.total,co.name   ' .
            ' order by co.id, o.payment                                             ',[$fair_id]);

    }

    public function getExtract($fair_id)
    {
        return DB::select(' select co.name Entrega,                              '.
        ' 	   o.payment as "tipo_pagamento",                  '.
        '        sum(o.total_products) as "total_produtos",    '.
        '        sum(o.total_shipping) as "total_entrega",           '.
        '        sum(o.total) as "total",                      '.
        '        count(o.id) as "total_cestas"                 '.
        ' from orders o,                                       '.
        ' couriers co                                          '.
        ' where o.courier_id = co.id                           '.
        ' 	  and o.order_status_id not in (3,6)               '.
        ' 	  and o.fair_id = ?                                '.
        ' group by co.name, o.payment                                    ',[$fair_id]);
    }

    public function getHarverstPayment($fair_id)
    {
        return DB::select('	select c.name as produtor,                              '.
            '		   p.name as produto,                               '.
            '		   sum(op.quantity) as quantidade,                  '.
            '		   sum(op.quantity*p.price) as valor_vendido        '.
            '	 from orders o,                                         '.
            '		 order_product op,                                  '.
            '		 products p,                                        '.
            '		 category_product cp,                               '.
            '		 categories c                                       '.
            '	where o.fair_id = ? and o.order_status_id not in (3,6)  '.
            '	and o.id = op.order_id and p.id = op.product_id         '.
            '	and cp.category_id = c.id and cp.product_id = p.id      '.
            '	group by c.name, p.name                                 ',[$fair_id]);
    }


}
