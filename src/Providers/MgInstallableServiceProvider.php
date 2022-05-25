<?php

namespace mgInstallable\installable\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use mgInstallable\installable\Middleware\canInstall;
use mgInstallable\installable\Middleware\canUpdate;

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
        $this->mergeConfigFrom(__DIR__ . '/../Config/Installable.php', 'Installable');
    }

    /**
     * Bootstrap the application events.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../views', 'Installable');
        $this->loadTranslationsFrom(__DIR__ . '/../Lang', 'Installable');

        $router->middlewareGroup('install', [CanInstall::class]);
        $router->middlewareGroup('update', [CanUpdate::class]);

        $this->publishFiles();
    }

    /**
     * Publish config file for the installable.
     *
     * @return void
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__ . '/../Config/Installable.php' => base_path('config/Installable.php'),
        ], 'Installable');

        $this->publishes([
            __DIR__ . '/../assets' => public_path('installable'),
        ], 'Installable');

        $this->publishes([
            __DIR__ . '/../Views' => base_path('resources/views/vendor/installable'),
        ], 'Installable');

        $this->publishes([
            __DIR__ . '/../Lang' => base_path('resources/lang'),
        ], 'Installable');
    }
}
