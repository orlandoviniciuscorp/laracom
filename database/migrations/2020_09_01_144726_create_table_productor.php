<?php

use App\Shop\Categories\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('producers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });


        $categories = app(CategoryRepository::class)->listCategories();


        foreach($categories as $category){

            $producer = new App\Shop\Producers\Producer();
            $producer->name = $category->name;
            $producer->slug = $category->slug;
            $producer->cover = $category->cover;
            $producer->status = $category->status;
            $producer->description = $category->description;
            dump('Migrando o ' .$producer->name);
            $producer->save();

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producers');
    }
}
