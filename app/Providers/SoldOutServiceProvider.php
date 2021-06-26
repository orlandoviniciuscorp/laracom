<?php


namespace App\Providers;


use App\Shop\Configurations\Repositories\ConfigurationRepository;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class SoldOutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('soldout',
            function($attribute, $value, $parameters, $validator){


                 $product = app(ProductRepository::class)->findProductById($value);


//                $configRepo = app(ConfigurationRepository::class);
//
//                $config = $configRepo->getConfig();
//
                return $product->quantity > 0;
            });
    }
}