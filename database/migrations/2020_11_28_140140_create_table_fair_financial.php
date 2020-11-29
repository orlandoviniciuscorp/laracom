<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFairFinancial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fair_financials', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('fair_id');
            $table->integer('producer_id');
            $table->integer('product_id');
            $table->integer('quantity');

            $table->float('farmer');
            $table->float('plataform');
            $table->float('separation');
            $table->float('fund');
            $table->float('payments_transfer');
            $table->float('accounting_close');
            $table->float('client_contact');
            $table->float('payment_conference');

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
        Schema::dropIfExists('fair_financials');
    }
}
