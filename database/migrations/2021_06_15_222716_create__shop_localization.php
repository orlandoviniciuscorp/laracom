<?php

use App\Shop\ShopLocalizations\ShopLocalization as ShopLocalization;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopLocalization extends Migration
{
    private $insertArray = ['Teresópolis', 'Rio de Janeiro'];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_localizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        collect($this->insertArray)->each(function ($item, $key) {
            $row = new ShopLocalization();
            $row->name = $item;
            $row->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_localizations');
    }
}
