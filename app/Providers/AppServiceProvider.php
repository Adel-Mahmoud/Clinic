<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\DomainModelMakeCommand;
use Illuminate\Foundation\Console\ModelMakeCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->extend(ModelMakeCommand::class, function ($command, $app) {
            return new DomainModelMakeCommand($app['files']);
        });
    }

    protected function mapDomainRoutes()
    {
        $domainsPath = app_path('Domains');

        foreach (glob($domainsPath . '/*/Routes/*.php') as $routeFile) {
            $this->loadRoutesFrom($routeFile);
        }
    }

    public function boot()
    {
        $this->app['router']->aliasMiddleware('auth.admin', \App\Http\Middleware\RedirectIfNotAdmin::class);
    $this->app['router']->aliasMiddleware('guest.admin', \App\Http\Middleware\RedirectIfAdmin::class);
        $this->mapDomainRoutes();
    }
}