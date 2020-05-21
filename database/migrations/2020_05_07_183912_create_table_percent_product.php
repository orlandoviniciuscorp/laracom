<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePercentProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_percents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->float('farmer')->nullable();
            $table->float('plataform')->nullable();
            $table->float('separation')->nullable();
            $table->float('fund')->nullable();
            $table->float('payments_transfer')->nullable();
            $table->float('client_contact')->nullable();
            $table->float('accounting_close')->nullable();
            $table->float('seeller')->nullable();
            $table->float('logistic')->nullable();


            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_percents');
    }
}
