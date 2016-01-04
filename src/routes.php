<?php

Route::group(['namespace' => 'Facilinfo\Gallery\Controllers', 'prefix'=>'gallery', 'middleware' => 'web'], function() {

    //CATEGORIES
    Route::resource('photo-categories', 'GalleryCategoryController');
    Route::post('photo-categories/reposition', ['uses' =>'GalleryCategoryController@reposition']);

    //SERIES
    Route::resource('photo-series', 'GallerySerieController');
    Route::post('photo-series/reposition', ['uses' =>'GallerySerieController@reposition']);

    //IMAGES
    Route::get('photo-images/create/{serie_id}', ['uses' => 'GalleryImageController@create', 'as' =>'photo_image_create']);

    Route::resource('photo-images', 'GalleryImageController');

    Route::get('photo-images/filter/{serie_id}', ['uses' => 'GalleryImageController@filter', 'as' => 'photo_images_filter']);

    Route::post('photo-images/reposition', ['uses' =>'GalleryImageController@reposition']);

});