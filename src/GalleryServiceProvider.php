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
        //require '../vendor/autoload.php';
        // Route
        include __DIR__.'/routes.php';
        // View
        $this->loadViewsFrom(__DIR__ . '/Views', 'gallery');
        $this->publishes([
            __DIR__ . '/Views' => $this->app->basePath() . '/resources/views'
        ], 'views');
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
    {//require '../vendor/autoload.php';
       /* $this->app['gallery'] = $this->app->share(function($app) {
            return new Gallery;
        });
       */

       //$this->app->register(P::class);

        $this->app->register(\Collective\Html\HtmlServiceProvider::class);

        // Bind breadcrumbs package
       /* $this->app->register(
            'DaveJamesMiller\Breadcrumbs\ServiceProvider'
        );
 */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Form', '\Collective\Html\FormFacade');


    }




}