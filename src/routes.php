<?php

Route::group(['namespace' => 'Facilinfo\Gallery\Controllers', 'prefix'=>'gallery', 'middleware' => 'web'], function() {
    Route::resource('photo-categories', 'GalleryCategoryController');

    Route::post('photo-categories/reposition', ['uses' =>'GalleryCategoryController@reposition']);



});