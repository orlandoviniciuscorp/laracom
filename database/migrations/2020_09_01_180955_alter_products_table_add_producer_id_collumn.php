<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductsTableAddProducerIdCollumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('producer_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('producer_id');
        });

        $products = app(\App\Shop\Products\Repositories\ProductRepository::class)->listProducts();
        dump('Atualizando ' . $products->count() . ' produtos.');
        foreach ($products as $product){

            dump("Atualizando o produto ". $product->name);
            foreach($product->categories as $category) {


                $producer = app(\App\Shop\Producers\Repositories\ProducerRepository::class)
                    ->findProducerBySlug(['slug'=>$category->slug]);
                dump("Associando o produto ". $product->name . " ao produtor " .$producer->name);
            $product->producer_id = $producer->id;
            $product->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('producer_id');
        });
    }
}
