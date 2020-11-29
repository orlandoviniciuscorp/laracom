<?php

namespace App\Shop\Fairs;

use App\Shop\Addresses\Address;
use App\Shop\Couriers\Courier;
use App\Shop\Customers\Customer;
use App\Shop\FairFinancials\FairFinancial;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Fair extends Model
{
    use SearchableTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'name',
        'start_at',
        'end_at',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function fairFinancials()
    {
        return $this->hasMany(FairFinancial::class)->orderBy('producer_id');
    }
}
