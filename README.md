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
  - [Login](#login)
  - [Logout](#logout)
  - [Get reset password link](#get-reset-password-link)
  - [Reset password with link](#reset-password-with-link)
  - [Update password for current user logged](#update-password-for-current-user-logged)
- [Customize](#customize)
  - [Defining Default Password Rules](#defining-default-password-rules)
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

Configure cors, you need edit the file `config/cors.php` and change this lines:

```php
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout', 'password/forget', 'password/reset'],

    /// ...

    'supports_credentials' => true,
```

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

### Login

```http
POST /login

{
    "email": " <email>",
    "password": "<password>"
}
```

### Logout

```http
POST /logout
```

### Get reset password link

```http
POST /password/forgot

{
    "email": " <email>"
}
```

### Reset password with link

```http
POST /password/reset

{
    "token": "<token>",
    "email": " <email>",
    "password": "<password>",
    "password_confirmation": "<password>"
}
```

### Update password for current user logged

```http
PUT /api/user/password

{
    "current_password": "<current_password>",
    "password": "<newpassword>",
    "password_confirmation": "<newpassword>"
}
```

### Get user info

```http
GET /api/user
```


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

### Defining Default Password Rules

You may find it convenient to specify the default validation rules for passwords in a single location of your application. You can easily accomplish this using the `Password::defaults` method, which accepts a closure. The closure given to the defaults method should return the default configuration of the Password rule. Typically, the `defaults` rule should be called within the `boot` method of one of your application's service providers:

```php
use Illuminate\Validation\Rules\Password;

/**
 * Bootstrap any application services.
 *
 * @return void
 */
public function boot()
{
    Password::defaults(function () {
        $rule = Password::min(8);

        return $this->app->isProduction()
                    ? $rule->mixedCase()->uncompromised()
                    : $rule;
    });
}
```

## More info

- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Nuxt Auth](https://auth.nuxtjs.org/providers/laravel-sanctum)
