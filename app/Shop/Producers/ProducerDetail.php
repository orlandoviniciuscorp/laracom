<?php

namespace App\Shop\Producers;

use App\Shop\Employees\Employee;
use App\Shop\Products\Product;
use Illuminate\Support\Facades\DB;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class ProducerDetail extends Model
{

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'producer_id',
        'product_id',
        'product_price'
    ];

//    protected $with=['products'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function producer(){
        return $this->belongsTo(Producer::class);
    }

    public function isAvailable()
    {
        $count = DB::select('select count(*) is_available from producer_product where product_id = ? and  producer_id = ?',
        [$this->product_id,$this->producer_id]);

        return $count[0]->is_available;

    }


}
