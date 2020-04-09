<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Fairs\Fair;
use App\Shop\Fairs\Repositories\FairRepository;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;

class DashboardController extends Controller
{
    public function index()
    {

        $fairRepo = new FairRepository(new Fair);

        $fair  = $fairRepo->find($fairRepo->findCurrentFair());

        $orderRepo = new OrderRepository(new Order);

        $totalOrders = $orderRepo->totalOrders($fair->id);

        $amount = $orderRepo->totalAmount($fair->id);

        $breadcumb = [
            ["name" => "Estatísticas", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcumb($breadcumb);


        return view('admin.dashboard')->with('fair',$fair)
            ->with('totalOrders',$totalOrders)
            ->with('amount',$amount);
    }
}
