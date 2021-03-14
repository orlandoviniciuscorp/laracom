<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCouriesAddSlugColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('couriers', function (Blueprint $table) {
            $table->string('slug')->nullable();
        });

        $couriers = \App\Shop\Couriers\Courier::all();
        foreach ($couriers as $courier) {
            dump($courier->name);
            $exploded = explode(' ', $courier->name);

            $part2 = '';
            if (is_numeric($exploded[1])) {
                $part2 = ' ' . $exploded[1];
            }

            $courier->slug = $exploded[0] . $part2;
            //            dump($courier->slug);
            $courier->save();
        }
        //        dd('fim');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('couriers', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
