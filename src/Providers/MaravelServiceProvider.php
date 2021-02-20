<?php

namespace Inani\Maravel\Providers;


use Illuminate\Support\ServiceProvider;
use Inani\Maravel\RoleManager;

class MaravelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RoleManager::class, function ($app) {
            return new RoleManager();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //

        $this->publishes([
            __DIR__.'/../database/' => database_path('migrations')
        ], 'migrations');
        $this->publishes([
            __DIR__.'/../database/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/maravels.php' => config_path('maravels.php')
        ], 'config');
    }
}
