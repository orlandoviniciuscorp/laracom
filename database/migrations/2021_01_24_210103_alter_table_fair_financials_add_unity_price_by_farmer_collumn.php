<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableFairFinancialsAddUnityPriceByFarmerCollumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fair_financials', function (Blueprint $table) {

            $table->float('unity_price_by_farmer')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fair_financials', function (Blueprint $table) {

            $table->dropColumn('unity_price_by_farmer');
        });
    }
}
