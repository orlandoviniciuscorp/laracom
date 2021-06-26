<?php


namespace App\Scope;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ShopLocalizationScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
//        dd(current_shop());
//        dd($builder->where('shop_id','=',current_shop()))
        if(auth()->guard('employee')->check()){
//            dd('oi');
           return;
        }
        if(current_shop()){
//            dd(current_shop());
            $builder->where('shop_id','=',current_shop());
        }


    }
}