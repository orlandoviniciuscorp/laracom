<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Configurations\Configuration;
use App\Shop\Fairs\Fair;
use App\Shop\Fairs\Repositories\FairRepository;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\Configurations\Repositories\ConfigurationRepository;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;

class DashboardController extends Controller
{
    public function __construct(
        ConfigurationRepository $configurationRepository
    ) {
        $this->configRepo = $configurationRepository;
    }
    public function index()
    {
        $fairRepo = new FairRepository(new Fair());

        $fair = $fairRepo->find($fairRepo->findLastFair(1));

        $fairRio = $fairRepo->find($fairRepo->findLastFair(2));

        $orderRepo = new OrderRepository(new Order());

        $totalOrders = 0;
        $amount = 0;

        if (!is_null($fair)) {
            $totalOrders = $orderRepo->totalOrders($fair->id);

            $amount = $orderRepo->totalAmount($fair->id);
        }


        $totalOrdersRio = 0;
        $amountRio = 0;

        if (!is_null($fairRio)) {
            $totalOrdersRio = $orderRepo->totalOrders($fairRio->id);

            $amountRio = $orderRepo->totalAmount($fairRio->id);
        }
        $breadcumb = [
            [
                'name' => 'Estatísticas',
                'url' => route('admin.dashboard'),
                'icon' => 'fa fa-dashboard',
            ],
            [
                'name' => 'Home',
                'url' => route('admin.dashboard'),
                'icon' => 'fa fa-home',
            ],
        ];
        populate_breadcumb($breadcumb);

        $this->checkPendency($fair);
        //

        return view('admin.dashboard')
            ->with('fair', $fair)
            ->with('fairRio', $fairRio)
            ->with('totalOrders', $totalOrders)
            ->with('amount', $amount)
            ->with('totalOrdersRio', $totalOrdersRio)
            ->with('amountRio', $amountRio)
            ->with('config', $this->getConfig())
            ->with('configRio', $this->getConfigRio())
            ->withErrors($this->checkPendency($fair));
    }

    public function open(Request $request)
    {
        $config = $this->getConfig();
        $config->is_open = $request->input('is_open');
        $this->configRepo->updateConfig($config);

        return redirect()->route('admin.dashboard');
    }

    public function openRio(Request $request)
    {
        $config = $this->getConfigRio();
        $config->is_open = $request->input('is_open');
        $this->configRepo->updateConfig($config);

        return redirect()->route('admin.dashboard');
    }

    public function showConfig(Request $request)
    {
        return view('admin.config.edit')->with('config', $this->getConfig());
    }

    public function storeConfig(Request $request)
    {
        //        $data = $request->except('_token', '_method');
        //        dd($data);
        $config = $this->getConfig();
        $config->is_open = $request->input('is_open');
        $config->is_automatic_open = $request->input('is_automatic_open');
        $config->is_automatic_close = $request->input('is_automatic_close');
        $config->automatic_fair = $request->input('automatic_fair');
        $config->automatic_clear_availability = $request->input(
            'automatic_clear_availability'
        );
        $config->send_email_on_buy_products = $request->input(
            'send_email_on_buy_products'
        );

        $config->show_message = $request->input('show_message');
        $config->fair_name = $request->input('fair_name');
        $config->next_fair_number = $request->input('next_fair_number');
        $config->message = $request->input('message');
        //        $config->quantity_top_sellers = $request->input('quantity_top_sellers');
        //        $config->is_fair_automatic = $request->input('is_fair_automatic');
        $this->configRepo->updateConfig($config);

        $request->session()->flash('message', $this->getSucessMesseger());
        return redirect(route('admin.dashboard'));
    }

    private function checkPendency($fair)
    {
        $erros = [];

        if (
            Product::where('status', '=', 1)
                ->whereDoesntHave('categories')
                ->get()
                ->count() > 0
        ) {
            array_push(
                $erros,
                'Há Produtos Habilitados sem categorias, por favor verificar em Pendências'
            );
        }

        if (
            Product::where('status', '=', 1)
                ->whereDoesntHave('producers')
                ->get()
                ->count() > 0
        ) {
            array_push(
                $erros,
                'Há Produtos Habilitados sem Produtores, por favor verificar em Pendências'
            );
        }

        return $erros;
    }
}
