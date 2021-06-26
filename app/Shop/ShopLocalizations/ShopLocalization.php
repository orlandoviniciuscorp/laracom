<?php

namespace App\Shop\ShopLocalizations;

use App\Shop\Categories\Category;
use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Model;

class ShopLocalization extends Model
{

    protected $fillable = ['name'];

    public function products(){
        return $this->hasMany(Product::class);

    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}



