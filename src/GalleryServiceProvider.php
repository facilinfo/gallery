<?php
namespace Facilinfo\Gallery;


class GalleryServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Config
        $this->publishes([
            __DIR__.'/Config/gallery.php' => config_path('gallery.php'),
        ], 'config');

        // Route
        include __DIR__.'/routes.php';
        // View
        $this->loadViewsFrom(__DIR__ . '/Views', 'gallery');
        $this->publishes([
            __DIR__ . '/Views' => $this->app->basePath() . '/resources/views'
        ], 'views');

        // Css
        $this->publishes([
            __DIR__ . '/Js' => $this->app->publicPath() . '/js'
        ], 'js');

        // Javascript
        $this->publishes([
            __DIR__ . '/Css' => $this->app->publicPath() . '/css'
        ], 'css');

        // Images
        $this->publishes([
            __DIR__ . '/Img' => $this->app->publicPath() . '/img'
        ], 'img');

        // Migrations
        $this->publishes([
            __DIR__ . '/Migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Config
        $this->mergeConfigFrom( __DIR__.'/Config/gallery.php', 'gallery');

        //Load dependencies
        $this->app->register(\AdamWathan\BootForms\BootFormsServiceProvider::class);
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('BootForm', '\AdamWathan\BootForms\Facades\BootForm');

        $this->app->register(\Intervention\Image\ImageServiceProvider::class);
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Image', '\Intervention\Image\Facades\Image');


        $this->app['gallery'] = $this->app->share(function($app) {
            return new Gallery;
        });
    }




}