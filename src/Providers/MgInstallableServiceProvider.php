<?php

namespace Dibiy\MgInstallable\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Dibiy\MgInstallable\Middleware\canInstall;
use Dibiy\MgInstallable\Middleware\canUpdate;

class MgInstallableServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishFiles();
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php', 'mginstallable');
        $this->loadViewsFrom(__DIR__ . '/../Views', 'mginstallable');
        $this->loadTranslationsFrom(__DIR__ . '/../Lang', 'mginstallable');
        $this->mergeConfigFrom(__DIR__ . '/../Config/Installable.php', 'mginstallable');
    }

    /**
     * Bootstrap the application events.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {

        $router->middlewareGroup('install', [CanInstall::class]);
        $router->middlewareGroup('update', [CanUpdate::class]);
    }

    /**
     * Publish config file for the installable.
     *
     * @return void
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__ . '/../Config/Installable.php' => config_path('Installable.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../assets' => public_path('mginstallable'),
        ], 'assets');

        $this->publishes([
            __DIR__ . '/../Views' => resource_path('views/vendor/mginstallable'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../Lang' => resource_path('lang'),
        ], 'lang');
    }
}
