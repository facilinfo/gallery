<?php

Route::group(['namespace' => 'Facilinfo\Gallery\Controllers', 'prefix'=>'gallery', 'middleware' => 'web'], function() {

    //CATEGORIES
    Route::resource('photo-categories', 'GalleryCategoryController');
    Route::post('photo-categories/reposition', ['uses' =>'GalleryCategoryController@reposition']);

    //SERIES
    Route::resource('photo-series', 'GallerySerieController');
    Route::post('photo-series/reposition', ['uses' =>'GallerySerieController@reposition']);



});