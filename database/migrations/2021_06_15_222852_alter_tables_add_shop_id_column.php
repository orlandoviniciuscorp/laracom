<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablesAddShopIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('shop_id')->default(1); //
        });

        Schema::table('couriers', function (Blueprint $table) {
            $table->integer('shop_id')->default(1); //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('shop_id'); //
        });

        Schema::table('couriers', function (Blueprint $table) {
            $table->dropColumn('shop_id'); //
        });
    }
}
