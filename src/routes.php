<?php

Route::group(['namespace' => 'Facilinfo\Gallery\Controllers', 'prefix'=>'gallery', 'middleware' => 'web'], function() {

    Route::get('photo-categories', 'GalleryCategoryController@index');
    Route::get('photo-categories/create', ['uses' => '\Facilinfo\Gallery\Controllers\GalleryCategoryController@create', 'as', 'testroute']);
    Route::post('photo-categories/store', ['uses' => '\Facilinfo\Gallery\Controllers\GalleryCategoryController@store', 'as', 'fgh']);
});