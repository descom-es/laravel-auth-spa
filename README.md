# Laravel Auth SPA

[![tests](https://github.com/descom-es/laravel-auth-spa/actions/workflows/tests.yml/badge.svg)](https://github.com/descom-es/laravel-auth-spa/actions/workflows/tests.yml)
[![analyse](https://github.com/descom-es/laravel-auth-spa/actions/workflows/analyse.yml/badge.svg)](https://github.com/descom-es/laravel-auth-spa/actions/workflows/analyse.yml)
[![style](https://github.com/descom-es/laravel-auth-spa/actions/workflows/style.yml/badge.svg)](https://github.com/descom-es/laravel-auth-spa/actions/workflows/style.yml)

This package is a agnostic authentication backend implementation for Laravel. Registers the
routes and controllers needed to implement all of Laravel'svauthentication features, including
login, password reset and more.

## Install

```bash
composer require descom/laravel-auth-spa
```

## Configure

```sh
php artisan vendor:publish --provider="Descom\AuthSpa\AuthSpaServiceProvider" --tag="config"
```

## Usage

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
