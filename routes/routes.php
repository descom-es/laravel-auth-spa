<?php

use Descom\AuthSpa\Http\Controllers\LoginController;
use Descom\AuthSpa\Http\Controllers\LogoutController;
use Descom\AuthSpa\Http\Controllers\Passwords\ResetController;
use Descom\AuthSpa\Http\Controllers\Passwords\ResetLinkController;
use Descom\AuthSpa\Http\Controllers\UserController;
use Descom\AuthSpa\Http\Controllers\ProfileInfoController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)
    ->middleware(['web'])
    ->name('login');

Route::post('logout', LogoutController::class)
    ->middleware(['web'])
    ->name('logout');

Route::post('/password/reset_link', ResetLinkController::class)
    ->middleware(['web'])
    ->name('password.reset_link');

Route::post('/password/reset', ResetController::class)
    ->middleware(['web'])
    ->name('password.reset');

Route::get(
    config('auth_spa.http.profile_info.path',  'user'),
    config('auth_spa.http.profile_info.controller',  ProfileInfoController::class)
)
    ->middleware(config('auth_spa.http.profile_info.middleware', ['api', 'auth:sanctum']))
    ->name('profile.info');
