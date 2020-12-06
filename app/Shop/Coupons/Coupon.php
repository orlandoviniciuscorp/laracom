<?php

namespace App\Shop\Coupons;

use App\Shop\Brands\Brand;
use App\Shop\Categories\Category;
use App\Shop\CouponTypes\CouponType;
use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\ProductImages\ProductImage;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nicolaslopezj\Searchable\SearchableTrait;

class Coupon extends Model
{
    use SearchableTrait;


    protected $with = ['couponType'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'percentage',
        'need_basket',
        'start_at',
        'expires_at',
        'status',
        'include_delivery',
        'coupon_type_id'

        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function couponType()
    {
        return $this->belongsTo(CouponType::class);
    }


}
