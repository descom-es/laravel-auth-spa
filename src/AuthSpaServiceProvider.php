<?php

namespace Descom\AuthSpa;

use Descom\AuthSpa\Console\Install;
use Illuminate\Auth\Notifications\ResetPassword;
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

        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return config('auth_spa.frontend.url').config('auth_spa.frontend.reset_password_url').'?token='.$token;
        });
    }
}
