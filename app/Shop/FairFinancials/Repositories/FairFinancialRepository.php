<?php

namespace App\Shop\FairFinancials\Repositories;

use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\FairFinancials\FairFinancial;
use App\Shop\Fairs\Fair;
use App\Shop\Fairs\Repositories\FairRepository;
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

class FairFinancialRepository extends BaseRepository
{
    use OrderTransformable;

    /**
     * OrderRepository constructor.
     * @param Order $order
     */
    public function __construct(FairFinancial $fairFinancial)
    {
        parent::__construct($fairFinancial);
        $this->model = $fairFinancial;
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

        return $this->model->where('status','=',1)->max('id');
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

    public function createFairFinancialByFairId($fair_id)
    {
        $fairRepo = new FairRepository(Fair::where('id','=',$fair_id)->first());
        $harvest = $fairRepo ->harvest($fair_id);

        foreach($harvest as $item) {
            $product = Product::where('id','=',$item->id)->first();
            $quantity = array();
//            dd($product->producers->count());
            foreach ($product->producers as $producer) {

                $quantity[$producer->id] = 0;
            }
            $productQuantity = $item->quantidade;
//            dd($quantity);

            while ($productQuantity != 0) {
                foreach ($quantity as $key => $value)
                    if ($productQuantity != 0) {
                        $quantity[$key] = $value + 1;
                        $productQuantity--;
                    }
            }
            foreach ($quantity as $key => $value) {
                $fairFinancial = new FairFinancial();
                $fairFinancial->fair_id = $fair_id;
                $fairFinancial->producer_id = $key;
                $fairFinancial->product_id = $product->id;
                $fairFinancial->quantity = $value;

                $fairFinancial->farmer = $product->percentage->farmer / 100 * $product->price * $value;
                $fairFinancial->plataform = $product->percentage->plataform / 100 * $product->price * $value;
                $fairFinancial->separation = $product->percentage->separation / 100 * $product->price * $value;
                $fairFinancial->fund = $product->percentage->fund / 100 * $product->price * $value;
                $fairFinancial->payments_transfer = $product->percentage->payments_transfer / 100 * $product->price * $value;
                $fairFinancial->accounting_close = $product->percentage->accounting_close / 100 * $product->price * $value;
                $fairFinancial->client_contact = $product->percentage->client_contact / 100 * $product->price * $value;
                $fairFinancial->payment_conference = $product->percentage->payment_conference / 100 * $product->price * $value;

                $this->create($fairFinancial->toArray());

            }
        }
    }

    public function refreshFairFinancial($fair_id){

         FairFinancial::where('fair_id','=',$fair_id)->delete();

         $this->createFairFinancialByFairId($fair_id);

    }

}
