<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategoryShopLocalization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_shop_localization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_localization_id');
            $table->integer('category_id');
            $table->timestamps();
        });

        $categories = app(\App\Shop\Categories\Repositories\CategoryRepository::class)->all();

        foreach($categories as $category){
            $category->shopLocalizations()->sync(1);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_shop_localization');
    }
}
