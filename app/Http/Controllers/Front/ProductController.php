<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Configurations\Repositories\ConfigurationRepository;
use App\Shop\Producers\Repositories\ProducerRepository;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Products\Transformations\ProductTransformable;

class ProductController extends Controller
{
    use ProductTransformable;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepo;



    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository,
                                CategoryRepositoryInterface $categoryRepository,
                                ConfigurationRepository $configurationRepository,
                                ProducerRepository $producerRepository)
    {
        $this->producerRepo = $producerRepository;
        $this->categoryRepo = $categoryRepository;
        $this->productRepo = $productRepository;
        $this->configRepo = $configurationRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        if (request()->has('q') && request()->input('q') != '') {
            $list = $this->productRepo->searchProduct(request()->input('q'));
        } else {
            $list = $this->productRepo->listProducts();
        }

        if(request()->has('exclude_sold_out') && request()->input('exclude_sold_out') == 1){
            $list = $list->where('quantity','>',0);
        }


        if(request()->has('order') && request()->input('order') == 1 ){
            $list = $list->sortBy('name');
        }

        $products = $list->where('status', 1)->map(function (Product $item) {
            return $this->transformProduct($item);
        });

        $perPage = 20;

        if(request()->has('page_itens') && request()->input('page_itens') != 0 ){
            $perPage = request()->input('page_itens');
        }

        return view('front.products.product-search', [
            'products' => $this->productRepo->paginateArrayResults($products->all(), $perPage),
            'config'=>$this->getConfig(),
            'cats'=>$this->getCategoryOrder()
        ]);
    }

    /**
     * Get the product
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $slug)
    {
//        dd($slug);
        $product = $this->productRepo->findProductBySlug(['slug' => $slug]);
        $images = $product->images()->get();
        $category = $product->categories()->first();
        $productAttributes = $product->attributes;
        $cats = $this->getCategoryOrder();
        $config= $this->getConfig();
        return view('front.products.product', compact(
            'product',
            'images',
            'productAttributes',
            'category',
            'cats',
            'config'
        ));
    }

    public function listProducts(){

        $list = $this->productRepo->listProducts('name','asc');
        $products = $list->where('status', 1)->map(function (Product $item) {
            return $this->transformProduct($item);
        });
        return view('front.products.product-list', [
            'cats'=>$this->getCategoryOrder(),
            'producers'=>$this->getProducerOrder(),
            'products' => $this->productRepo->paginateArrayResults($products->all(), 30),
            'config'=> $this->getConfig()
        ]);

    }
}
