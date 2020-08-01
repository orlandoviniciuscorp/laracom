<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Configurations\Repositories\ConfigurationRepository;
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
                                ConfigurationRepository $configurationRepository)
    {
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

        $products = $list->where('status', 1)->map(function (Product $item) {
            return $this->transformProduct($item);
        });

        return view('front.products.product-search', [
            'products' => $this->productRepo->paginateArrayResults($products->all(), 10),
            'config'=>$this->getConfig()
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
        $product = $this->productRepo->findProductBySlug(['slug' => $slug]);
        $images = $product->images()->get();
        $category = $product->categories()->first();
        $productAttributes = $product->attributes;

        return view('front.products.product', compact(
            'product',
            'images',
            'productAttributes',
            'category'
        ));
    }

    public function listProducts(){

        $list = $this->productRepo->listProducts();
        $products = $list->where('status', 1)->map(function (Product $item) {
            return $this->transformProduct($item);
        });
        return view('front.products.product-list', [
            'cats'=>$this->getCategoryOrder(),
            'products' => $this->productRepo->paginateArrayResults($products->all(), 10),
            'config'=> $this->getConfig()
        ]);

    }
}
