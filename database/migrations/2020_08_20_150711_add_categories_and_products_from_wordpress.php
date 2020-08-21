<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoriesAndProductsFromWordpress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::select('delete from orders');
        DB::select('delete from categories');
        DB::select('delete from products');

        
        $categoriesWp = DB::select('select * from wpji_terms where (term_id >= 15 and term_id <= 77) or term_id >= 115 and term_id not in(130,127)');

        foreach($categoriesWp as $categoryWp) {

            $category = new \App\Shop\Categories\Category();
            $category->name = $categoryWp->name;
            $category->slug = $categoryWp->slug;
            $category->status = 1;


            $category->save();

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
