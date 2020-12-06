<?php

use App\Shop\CouponTypes\CouponTypes;
use Illuminate\Database\Seeder;

class CouponTypesTableSeeder extends Seeder
{
    public function run()
    {
        factory(CouponTypes::class)->create([
            'name' => 'fixo',
        ]);

        factory(CouponTypes::class)->create([
            'name' => 'percentual',
        ]);


    }
}