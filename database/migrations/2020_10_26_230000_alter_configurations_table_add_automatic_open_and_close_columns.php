<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfigurationsTableAddAutomaticOpenAndCloseColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {

            $table->boolean('is_automatic_open')->default(true);
            $table->boolean('is_automatic_close')->default(true);

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

            $table->dropColumn('is_automatic_open');
            $table->dropColumn('is_automatic_close');
        });
    }
}
