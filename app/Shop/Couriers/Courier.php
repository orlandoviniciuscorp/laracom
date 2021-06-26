<?php

namespace App\Shop\Couriers;

use App\Scope\ShopLocalizationScope;
use App\Shop\Orders\Order;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'url',
        'is_free',
        'cost',
        'status',
        'slug',
        'shop_id',
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

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ShopLocalizationScope());

    }
}
