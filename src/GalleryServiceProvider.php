<?php

namespace Facilinfo\Gallery;

use Illuminate\Support\ServiceProvider;

class GalleryServiceProvider extends ServiceProvider
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
    }
}
