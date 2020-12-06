<?php

namespace App\Providers;

use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Categories\Category;
use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Employees\Employee;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Producers\Producer;
use App\Shop\Producers\Repositories\ProducerRepository;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Transformations\ProductTransformable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

/**
 * Class GlobalTemplateServiceProvider
 * @package App\Providers
 * @codeCoverageIgnore
 */
class GlobalTemplateServiceProvider extends ServiceProvider
{

    use ProductTransformable;

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'layouts.admin.app',
            'layouts.admin.sidebar',
            'admin.shared.products'
        ], function ($view) {
            $view->with('admin', Auth::guard('employee')->user());
        });
        //dd($this->getCategories());
        view()->composer(['layouts.front.app', 'front.categories.sidebar-category','front.index'], function ($view) {
            $view->with('categories', $this->getCategories());
            $view->with('producers', $this->getProducers());
            $view->with('cartCount', $this->getCartCount());
            $view->with('totalCartItens',$this->getTotalItems());
            $view->with('newestProducts',$this->getNewestProducts());
            $view->with('producsInPromotion',$this->getPromotionProducts());
        });

        /**
         * breadcumb
         */
        view()->composer([
            "layouts.admin.app"
        ], function ($view) {
            $breadcumb = [
                ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ];
            $paths = request()->segments();
            if (count($paths) > 1) {
                foreach ($paths as $key => $pah) {
                    if ($key == 1)
                        $breadcumb[] = ["name" => ucfirst($pah), "url" => request()->getBaseUrl() . "/" . $paths[0] . "/" . $paths[$key], 'icon' => config("module.admin." . $pah . ".icon")];
                    elseif ($key == 2)
                        $breadcumb[] = ["name" => ucfirst($pah), "url" => request()->getBaseUrl() . "/" . $paths[0] . "/" . $paths[1] . "/" . $paths[$key], 'icon' => config("module.admin." . $pah . ".icon")];
                }
            }
            $view->with(
                [
                    "breadcumbs" => $breadcumb
                ]
            );
        });


        view()->composer(['layouts.front.category-nav'], function ($view) {
            $view->with('categories', $this->getCategories());
            $view->with('producers', $this->getProducers());
        });
    }

    /**
     * Get all the categories
     *
     */
    private function getCategories()
    {
        $categoryRepo = new CategoryRepository(new Category);
        return $categoryRepo->allActive();

    }

    private function getProducers(){
        $producerRepo = new ProducerRepository(new Producer);
        return $producerRepo->allActive();
    }

    private function getNewestProducts(){
        $productRepo = new ProductRepository(new Product);
        $newestList = $productRepo->listProducts('created_at','desc');
        return  $newestList->where('status',1)->take(10)->map(function (Product $item){
            return $this->transformProduct($item);
        });

    }

    private function getPromotionProducts(){
        $productRepo = new ProductRepository(new Product);
        $newestList = $productRepo->listProducts('created_at','desc');
        return  $newestList->where('is_in_promotion',1)->take(10)->map(function (Product $item){
            return $this->transformProduct($item);
        });
    }
    /**
     * @return int
     */
    private function getCartCount()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        return $cartRepo->countItems();
    }

    private function getTotalItems(){
        $cartRepo = new CartRepository(new ShoppingCart);
        return $cartRepo->getTotal();
    }

    /**
     * @param Employee $employee
     * @return bool
     */
    private function isAdmin(Employee $employee)
    {
        $employeeRepo = new EmployeeRepository($employee);
        return $employeeRepo->hasRole('admin');
    }
}
