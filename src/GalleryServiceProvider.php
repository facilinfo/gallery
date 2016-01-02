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
        // Route
        include __DIR__.'/routes.php';
        // View
        $this->loadViewsFrom(__DIR__ . '/Views', 'gallery');
        $this->publishes([
            __DIR__ . '/Views' => $this->app->basePath() . '/resources/views'
        ], 'views');

        // Javascript
        $this->publishes([
            __DIR__ . '/Js' => $this->app->publicPath() . '/js'
        ], 'migrations');

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
        $this->app['gallery'] = $this->app->share(function($app) {
            return new Gallery;
        });

        //Load dependencies
        $this->app->register(\AdamWathan\BootForms\BootFormsServiceProvider::class);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('BootForm', '\AdamWathan\BootForms\Facades\BootForm');
    }




}