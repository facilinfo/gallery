<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryCategoriesTable extends Migration {

    public function up() {
        Schema::create('gallery_categories', function(Blueprint $table) {
            $table->increments('id');

            $table->string('name', 255);
            $table->string('slug', 255);
            $table->integer('position')->unsigned;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('gallery_categories');
    }

}
