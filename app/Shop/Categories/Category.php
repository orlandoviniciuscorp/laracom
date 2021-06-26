<?php

namespace App\Shop\Categories;


use App\Scope\CategoryShopLocalizationScope;
use App\Shop\CategoryShopLocalizations\CategoryShopLocalization;
use App\Shop\Products\Product;
use App\Shop\ShopLocalizations\ShopLocalization;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use NodeTrait;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover',
        'status',
        'parent_id',
        'page_order'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function shopLocalizations()
    {
        return $this->belongsToMany(ShopLocalization::class);
    }

    public static function boot(){
        parent::boot();

        static::addGlobalScope(new CategoryShopLocalizationScope());
    }
}
