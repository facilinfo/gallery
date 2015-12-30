<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsanovaDemoItemsTable extends Migration
{
public function up()
{
Schema::create('websanova_demo_items', function(Blueprint $t)
{
$t->increments('id')->unsigned();
$t->text('slug', 255);
$t->text('name', 255);
$t->text('description', 255);
$t->timestamps();
});
}

public function down()
{
Schema::drop('websanova_demo_items');
}
}
