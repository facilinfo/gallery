<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryImagesTable extends Migration
{
    public function up() {
        Schema::create('gallery_images', function(Blueprint $table) {
            $table->increments('id');
            $table->string('legend', 255);
            $table->string('extension', 4);
            $table->string('path', 255);
            $table->boolean('first')->default(false);
            $table->integer('position')->unsigned();
            $table->integer('serie_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('gallery_images',function(Blueprint $table) {
            $table->foreign('serie_id')
                ->references('id')->on('gallery_series')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('gallery_images');
    }

}
