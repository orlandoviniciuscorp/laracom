<?php

namespace App\Shop\Orders\Transformers;

use App\Shop\Addresses\Address;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Coupons\Coupon;
use App\Shop\Coupons\Repositories\CouponRepository;
use App\Shop\Couriers\Courier;
use App\Shop\Couriers\Repositories\CourierRepository;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Fairs\Repositories\FairRepository;
use App\Shop\Orders\Order;
use App\Shop\Fairs\Fair;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;

trait OrderTransformable
{
    /**
     * Transform the order
     *
     * @param Order $order
     * @return Order
     */
    protected function transformOrder(Order $order) : Order
    {
        $courierRepo = new CourierRepository(new Courier());
        $order->courier = $courierRepo->findCourierById($order->courier_id,false);

        $customerRepo = new CustomerRepository(new Customer());
        $order->customer = $customerRepo->findCustomerById($order->customer_id);

        $addressRepo = new AddressRepository(new Address());
        $order->address = $addressRepo->findAddressById($order->address_id);

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus());
        $order->status = $orderStatusRepo->findOrderStatusById($order->order_status_id);

        $fairRepo = new FairRepository(new Fair());
        $order->fair = $fairRepo->findFairById($order->fair_id);

        if (!is_null($order->coupon_id)){
            $couponRepo = new CouponRepository(new Coupon());
            $order->coupon_id = $couponRepo->findBy(['id' => $order->coupon_id]);
        }

        return $order;
    }
}
