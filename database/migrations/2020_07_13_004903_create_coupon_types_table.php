<?php

use App\Shop\CouponTypes\CouponType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('coupon_types');
        Schema::create('coupon_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');

            $table->timestamps();
        });

        app(CouponType::class)->create(['name'=>'Fixo',
        'description'=>'Valor Fixo de desconto']);

        app(CouponType::class)->create(['name'=>'Percentual',
            'description'=>'Valor por percentual']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_types');
    }
}
