<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * Admin routes
 */
Route::namespace('Admin')->group(function () {
    Route::get('admin/login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('admin/login', 'LoginController@login')->name('admin.login');
    Route::get('admin/logout', 'LoginController@logout')->name('admin.logout');
});
Route::group(['prefix' => 'admin', 'middleware' => ['employee'], 'as' => 'admin.' ], function () {
    Route::namespace('Admin')->group(function () {
        Route::group(['middleware' => ['role:admin|superadmin|clerk, guard:employee']], function () {
            Route::get('/', 'DashboardController@index')->name('dashboard');
            Route::post('/open-site', 'DashboardController@open')->name('config.open');

            Route::group(['prefix'=>'percentages'],function(){
               Route::get('/create','Percentages\PercentageController@create')->name('percentages.create');
               Route::get('/','Percentages\PercentageController@index')->name('percentages.index');
               Route::post('/store','Percentages\PercentageController@store')->name('percentages.store');
            });

            Route::namespace('Products')->group(function () {

                Route::post('/update-quantity', 'ProductController@updateQuantity')->name('products.update-quantity');
                Route::post('/update-quantity-batch', 'ProductController@updateQuantityBatch')->name('products.update-quantity-batch');
                Route::post('/empty-availability', 'ProductController@emptyAvailability')->name('products.empty-availability');
                Route::post('/disable-empty-products', 'ProductController@disableEmptyProducts')->name('products.disable-empty-products');
                Route::post('/{product_id}/disabled','ProductController@disabledProduct')->name('products.disabled');
                Route::post('/{product_id}/enabled','ProductController@enabledProduct')->name('products.enabled');
                Route::get('/{product_id}/percents','ProductController@indexPercent')->name('percents.index');
                Route::post('/{product_id}/percents/store','ProductController@percentStore')->name('percents.store');
                Route::resource('products', 'ProductController');
                Route::get('remove-image-product', 'ProductController@removeImage')->name('product.remove.image');
                Route::get('remove-image-thumb', 'ProductController@removeThumbnail')->name('product.remove.thumb');
            });
            Route::namespace('Customers')->group(function () {
                Route::get('customers/history','CustomerController@history')->name('customers.history');
                Route::resource('customers', 'CustomerController');
                Route::resource('customers.addresses', 'CustomerAddressController');
            });
            Route::namespace('Categories')->group(function () {
                Route::post('rotate-farmers', 'CategoryController@rotateFarmers')->name('category.rotate-farmers');
                Route::resource('categories', 'CategoryController');
                Route::get('remove-image-category', 'CategoryController@removeImage')->name('category.remove.image');
                Route::get('/list-batch','CategoryController@listCategories')->name('categories.list.products');
                Route::get('/list-batch/{id}','CategoryController@listProductsBatch')->name('categories.products.list-batch');

            });
            Route::namespace('Orders')->group(function () {
                Route::resource('orders', 'OrderController');
                Route::resource('order-statuses', 'OrderStatusController');
                Route::get('orders/{id}/invoice', 'OrderController@generateInvoice')->name('orders.invoice.generate');
                Route::post('orders/{id}/mark-as-payed', 'OrderController@markAsPayed')->name('orders.mark-as-payed');
            });

            Route::group(['prefix'=>'fairs'],function () {
                Route::get('/','Fairs\FairController@index')->name('fairs.index');
                Route::get('/create','Fairs\FairController@create')->name('fairs.create');
                Route::post('/store','Fairs\FairController@store')->name('fair.store');
                Route::get('/{fair_id}/show/','Fairs\FairController@show')->name('fair.show');
                Route::get('/{fair_id}/order/','Fairs\FairController@showOrders')->name('fair.orders-list');
                Route::get('/{fair_id}/harvest/','Fairs\FairController@showHarvest')->name('fair.harvest');
                Route::get('/{fair_id}/labels/', 'Fairs\FairController@generateLabel')->name('fair.labels');
                Route::get('/{fair_id}/pending', 'Fairs\FairController@getOrderPending')->name('fair.pending');
                Route::get('/{fair_id}/delivery', 'Fairs\FairController@generateDeliveryList')->name('fair.delivery');
                Route::get('/{fair_id}/financial', 'Fairs\FairController@financial')->name('fair.financial');
                Route::get('/{fair_id}/detail-report', 'Fairs\FairController@detailReport')->name('fair.detail-report');


            });

            Route::resource('addresses', 'Addresses\AddressController');
            Route::resource('countries', 'Countries\CountryController');
            Route::resource('countries.provinces', 'Provinces\ProvinceController');
            Route::resource('countries.provinces.cities', 'Cities\CityController');
            Route::resource('couriers', 'Couriers\CourierController');
            Route::resource('attributes', 'Attributes\AttributeController');
            Route::resource('attributes.values', 'Attributes\AttributeValueController');
            Route::resource('brands', 'Brands\BrandController');

        });
        Route::group(['middleware' => ['role:admin|superadmin, guard:employee']], function () {
            Route::resource('employees', 'EmployeeController');
            Route::get('employees/{id}/profile', 'EmployeeController@getProfile')->name('employee.profile');
            Route::put('employees/{id}/profile', 'EmployeeController@updateProfile')->name('employee.profile.update');
            Route::resource('roles', 'Roles\RoleController');
            Route::resource('permissions', 'Permissions\PermissionController');
        });
    });
});

/**
 * Frontend routes
 */
Auth::routes();
Route::namespace('Auth')->group(function () {
    Route::get('cart/login', 'CartLoginController@showLoginForm')->name('cart.login');
    Route::post('cart/login', 'CartLoginController@login')->name('cart.login');
    Route::get('logout', 'LoginController@logout');
});

Route::namespace('Front')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/products','ProductController@listProducts')->name('product.list');
    Route::group(['middleware' => ['auth', 'web']], function () {


        Route::namespace('Payments')->group(function () {
            Route::get('bank-transfer', 'BankTransferController@index')->name('bank-transfer.index');
            Route::post('bank-transfer', 'BankTransferController@store')->name('bank-transfer.store');

            Route::get('pay-on-delivery', 'PayOnDeliveryController@index')->name('pay-on-delivery.index');
            Route::post('pay-on-delivery', 'PayOnDeliveryController@store')->name('pay-on-delivery.store');
        });

        Route::namespace('Addresses')->group(function () {
            Route::resource('country.state', 'CountryStateController');
            Route::resource('state.city', 'StateCityController');
        });

        Route::get('accounts', 'AccountsController@index')->name('accounts');
        Route::get('orders', 'AccountsController@orders')->name('orders');
        Route::get('addresses', 'AccountsController@addresses')->name('addresses');
        Route::post('cancel-order', 'AccountsController@cancelOrder')->name('accounts.cancel-order');
        Route::get('checkout/{courier_id}', 'CheckoutController@index')->name('checkout.index');
        Route::post('checkout/store', 'CheckoutController@store')->name('checkout.store');
        Route::post('checkout/cart', 'CheckoutController@index')->name('cart.checkout');
        Route::get('checkout/execute', 'CheckoutController@executePayPalPayment')->name('checkout.execute');
        Route::post('checkout/execute', 'CheckoutController@charge')->name('checkout.execute');
        Route::get('checkout/cancel', 'CheckoutController@cancel')->name('checkout.cancel');
        Route::get('checkout/success', 'CheckoutController@success')->name('checkout.success');
        Route::resource('customer.address', 'CustomerAddressController');
    });
    Route::resource('cart', 'CartController');
    Route::post("/add-to-cart", 'CartController@addToCartAjax')->name('front.add.cart');
    Route::get("category/{slug}", 'CategoryController@getCategory')->name('front.category.slug');
    Route::get("search", 'ProductController@search')->name('search.product');
    Route::get("{product}", 'ProductController@show')->name('front.get.product');


});