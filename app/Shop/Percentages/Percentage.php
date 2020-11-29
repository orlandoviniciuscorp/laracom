<?php

namespace App\Shop\Percentages;

use App\Shop\Brands\Brand;
use App\Shop\Categories\Category;
use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\ProductImages\ProductImage;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nicolaslopezj\Searchable\SearchableTrait;

class Percentage extends Model
{
    use SearchableTrait;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'farmer',
        'plataform',
        'separation',
        'fund',
        'payments_transfer',
        'accounting_close',
        'client_contact',
        'payment_conference'

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
}
