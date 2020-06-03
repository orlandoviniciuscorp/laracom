<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCourierTableAddCepAndNumberCollumns extends Migration
{
    public function up()
    {
        Schema::table('couriers', function (Blueprint $table){
            $table->text('cep')->nullable();
            $table->text('number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('couriers', function (Blueprint $table){
            $table->dropColumn('cep');
            $table->dropColumn('number');
        });
    }
}
