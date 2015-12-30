<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGallerySeriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('gallery_series', function(Blueprint $table) {
            $table->increments('id');

            $table->string('name', 255);
            $table->string('slug', 255);
            $table->longText('description');
            $table->boolean('active')->default(false);
            $table->integer('position')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')->on('gallery_categories')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('gallery_series');
    }

}
