# Laravel Auth SPA

[![tests](https://github.com/descom-es/laravel-auth-spa/actions/workflows/tests.yml/badge.svg)](https://github.com/descom-es/laravel-auth-spa/actions/workflows/tests.yml)
[![analyse](https://github.com/descom-es/laravel-auth-spa/actions/workflows/analyse.yml/badge.svg)](https://github.com/descom-es/laravel-auth-spa/actions/workflows/analyse.yml)
[![style](https://github.com/descom-es/laravel-auth-spa/actions/workflows/style.yml/badge.svg)](https://github.com/descom-es/laravel-auth-spa/actions/workflows/style.yml)

This package is an authentication backend implementation for Laravel. Registers the routes
and controllers required to implement all Laravel authentication features from a Frontend
SPA or SSR, including login, password reset, and more.

- [Installation](#installation)
- [Configure](#configure)
  - [Laravel Sanctum](#laravel-sanctum)
  - [Package](#package)
- [Usage](#usage)
- [Customize](#customize)
- [More info](#more-info)


## Installation

```bash
composer require descom/laravel-auth-spa
```

## Configure

### Laravel Sanctum

Run:

```sh
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
````

Add Sanctum's middleware to your api middleware group within your application's `app/Http/Kernel.php` file:

```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

Setting the `supports_credentials` option within your application's `config/cors.php` configuration file to `true`.

In production define this environment variables:

Local:

```env
SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=localhost
```

Production for domain 'www.app.tld':

```env
SANCTUM_STATEFUL_DOMAINS=www.app.tld
SESSION_DOMAIN=.app.tld
```

### Package

```sh
php artisan vendor:publish --provider="Descom\AuthSpa\AuthSpaServiceProvider" --tag="config"
```

You can define your frontend in config file `config/authspa.php`

```php
///
    'frontend' => [
        'url' => env('FRONTEND_URL', 'http://localhost:3000'),

        'reset_password_url' => env('FRONTEND_RESET_PASSWORD_URL', '/login/reset'),
    ],
///
```

## Usage

## API Http Requests

- [POST] `/login`
- [POST] `/logout`
- [POST] `/password/reset_link`
- [POST] `/password/reset`
- [GET] `/api/user`

### Nuxt.js

Install Nuxt Auth:

```sh
yarn add --exact @nuxtjs/auth-next
yarn add @nuxtjs/axios
```

And configure file `nuxt.config.js`:

```js
{
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth-next'
  ],
  auth: {
    strategies: {
      laravelSanctum: {
        provider: 'laravel/sanctum',
        url: process.env.API_URL || 'http://localhost:8000',
      },
    },
  }
}
```

## Customize

### Customize User Info

You can define your own controller to get User Info, edit the file `config/auth-spa.php`

```php

    'http' => [
        'profile_info' => [
            'controller' => \Descom\AuthSpa\Http\Controllers\ProfileInfoController::class,

            'middleware' => ['api', 'auth:sanctum'],

            'path' => 'user',
        ],
    ],

```

And define your own controller:

```php
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(Auth::user()->load(['roles', 'clients']));
    }
}
```


## More info

- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Nuxt Auth](https://auth.nuxtjs.org/providers/laravel-sanctum)
