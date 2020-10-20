<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Configurations\Configuration;
use App\Shop\Fairs\Fair;
use App\Shop\Fairs\Repositories\FairRepository;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\Configurations\Repositories\ConfigurationRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        ConfigurationRepository $configurationRepository){
        $this->configRepo = $configurationRepository;
    }
    public function index()
    {

        $fairRepo = new FairRepository(new Fair);

        $fair  = $fairRepo->find($fairRepo->findLastFair());

        $orderRepo = new OrderRepository(new Order);

        $totalOrders = 0;
        $amount = 0;

        if(!is_null($fair)) {
            $totalOrders = $orderRepo->totalOrders($fair->id);

            $amount = $orderRepo->totalAmount($fair->id);
        }
        $breadcumb = [
            ["name" => "Estatísticas", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcumb($breadcumb);


        return view('admin.dashboard')->with('fair',$fair)
            ->with('totalOrders',$totalOrders)
            ->with('amount',$amount)
            ->with('config',$this->getConfig());
    }

    public function open(Request $request)
    {
        $config = $this->getConfig();
        $config->is_open = $request->input('is_open');
        $this->configRepo->updateConfig($config);

        return redirect()->route('admin.dashboard');
    }

    public function showConfig(Request $request){
        return view('admin.config.edit')->with('config',$this->getConfig());
    }

    public function storeConfig(Request $request)
    {
//        $data = $request->except('_token', '_method');
//        dump($data);
        $config = $this->getConfig();
        $config->is_open = $request->input('is_open');
        $config->is_automatic_open = $request->input('is_automatic_open');
        $config->is_automatic_close = $request->input('is_automatic_close');
        $config->is_warning_stock_low = $request->input('is_warning_stock_low');
        $config->quantity_stock_low = $request->input('quantity_stock_low');
        $config->quantity_top_sellers = $request->input('quantity_top_sellers');
        $config->is_fair_automatic = $request->input('is_fair_automatic');
        $this->configRepo->updateConfig($config);

        $request->session()->flash('message',$this->getSucessMesseger());
        return redirect(route('admin.dashboard'));

    }
}
