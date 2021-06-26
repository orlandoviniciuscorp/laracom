<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Configurations\Repositories\ConfigurationRepository;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Transformations\ProductTransformable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HomeController extends Controller
{

    use ProductTransformable;

    /**
     * HomeController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     * @param ConfigurationRepository $configurationRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository,
    ConfigurationRepository $configurationRepository,
    ProductRepository $productRepository)
    {
        $this->categoryRepo = $categoryRepository;
        $this->configRepo = $configurationRepository;
        $this->productRepo = $productRepository;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        return view('front.index')->with('cats',$this->getCategoryOrder())
            ->with('config',$this->getConfig());
    }

    public function select(){
        return view('front.select');
    }

    public function selectCity(Request $request)
    {
        $city = $request->get('shop_type');
        $session = app()->get('session');
//        dd($session('shop_type');
        $session->put(['shop_type'=>$city]);

//        if($city == 'rio'){
//            return redirect()->route('home.rio');
//        }else{
            return redirect()->route('home');
//        }

    }

    public function basketRio(Request $request)
    {

        $products = $this->productRepo->listProducts('created_at','desc')
//            ->where('status',1)->
//            where('is_basket',1)
        ;




//            dd( Collection::make($products));


        return view('front.basket.basket-list')->with('cats',$this->getCategoryOrder())
            ->with('config',$this->getConfig())
            ->with('products', $products);
    }
}
