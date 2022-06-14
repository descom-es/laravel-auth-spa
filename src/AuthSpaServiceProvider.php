<?php

namespace Descom\AuthSpa;

use Descom\AuthSpa\Console\Install;
use Illuminate\Support\ServiceProvider;

class AuthSpaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'auth_spa');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
              __DIR__.'/../config/config.php' => config_path('auth_spa.php'),
            ], 'config');

            $this->commands([
                Install::class,
            ]);
        }
    }
}
