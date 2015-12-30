<?php

Route::group(['namespace' => 'Facilinfo\Gallery\Controllers', 'prefix'=>'gallery'], function() {
    Route::get('photo-categories', 'PhotoCategoryController@index');
});