<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableConfigurationsAddColumnsCreateAutomaticFair extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('automatic_fair')->default(false);
            $table->text('fair_name')->nullable();
            $table->integer('next_fair_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('automatic_fair');
            $table->dropColumn('fair_name');
            $table->dropColumn('next_fair_number');
        });
    }
}
