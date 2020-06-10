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

    public const MASS_UNIT = [
        'OUNCES' => 'oz',
        'GRAMS' => 'gms',
        'POUNDS' => 'lbs'
    ];

    public const DISTANCE_UNIT = [
        'CENTIMETER' => 'cm',
        'METER' => 'mtr',
        'INCH' => 'in',
        'MILIMETER' => 'mm',
        'FOOT' => 'ft',
        'YARD' => 'yd'
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'products.name' => 10,
            'products.description' => 5
        ]
    ];

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
        'bags',
        'payment_online',
        'accounting_close',
        'marketing',
        'administration',
        'seeller',
        'pickup_location',
        'logistic',
        'client_contact',
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
