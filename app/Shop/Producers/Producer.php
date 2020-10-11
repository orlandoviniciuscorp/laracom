<?php

namespace App\Shop\Producers;

use App\Shop\Employees\Employee;
use App\Shop\Products\Product;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{

    
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
        return $this->hasMany(Product::class);
    }

    public function employee(){
        return $this->hasMany(Employee::class);
    }
}
