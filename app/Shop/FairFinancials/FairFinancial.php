<?php

namespace App\Shop\FairFinancials;

use App\Shop\Addresses\Address;
use App\Shop\Couriers\Courier;
use App\Shop\Customers\Customer;
use App\Shop\Fairs\Fair;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\Producers\Producer;
use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class FairFinancial extends Model
{
    use SearchableTrait;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
            'fair_id',
            'producer_id',
            'product_id',
            'quantity',
            'farmer',
            'plataform',
            'separation',
            'fund',
            'payments_transfer',
            'accounting_close',
            'client_contact',
            'payment_conference',
            'unity_price_by_farmer'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function fair(){
        return $this->belongsTo(Fair::class);
    }

    public function producer(){
        return $this->belongsTo(Producer::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function sumProducer(){

        return $this->where('producer_id','=',$this->producer_id)
            ->where('fair_id','=',$this->fair_id)->sum(\DB::raw('unity_price_by_farmer*quantity'));
    }

    public function sumPlataform()
    {
        return $this->where('fair_id','=',$this->fair_id)->sum('plataform');
    }

    public function sumSeparation()
    {
        return $this->where('fair_id','=',$this->fair_id)->sum('separation');
    }

    public function sumFund()
    {
        return $this->where('fair_id','=',$this->fair_id)->sum('fund');
    }

    public function sumPaymentsTransfer()
    {
        return $this->where('fair_id','=',$this->fair_id)->sum('payments_transfer');
    }

    public function sumAccountingClose()
    {
        return $this->where('fair_id','=',$this->fair_id)->sum('accounting_close');
    }

    public function sumClientContact()
    {
        return $this->where('fair_id','=',$this->fair_id)->sum('client_contact');
    }

    public function sumPaymentConference()
    {
        return $this->where('fair_id','=',$this->fair_id)->sum('payment_conference');
    }

}
