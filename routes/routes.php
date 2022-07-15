<?php

use Descom\AuthSpa\Http\Controllers\LoginController;
use Descom\AuthSpa\Http\Controllers\LogoutController;
use Descom\AuthSpa\Http\Controllers\Passwords\ChangePasswordController;
use Descom\AuthSpa\Http\Controllers\Passwords\ForgotPasswordController;
use Descom\AuthSpa\Http\Controllers\Passwords\ResetPasswordController;
use Descom\AuthSpa\Http\Controllers\ProfileInfoController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)
    ->middleware(['web'])
    ->name('login');

Route::post('logout', LogoutController::class)
    ->middleware(['web'])
    ->name('logout');

Route::post('/password/forgot', ForgotPasswordController::class)
    ->middleware(['web'])
    ->name('password.forgot');

Route::post('/password/reset', ResetPasswordController::class)
    ->middleware(['web'])
    ->name('password.reset');

Route::post('/password/change', ChangePasswordController::class)
    ->middleware(['web', 'auth:sanctum'])
    ->name('password.change');

Route::get(
    config('auth_spa.http.profile_info.path',  'api/user'),
    config('auth_spa.http.profile_info.controller',  ProfileInfoController::class)
)
    ->middleware(config('auth_spa.http.profile_info.middleware', ['api', 'auth:sanctum']))
    ->name('profile.info');
