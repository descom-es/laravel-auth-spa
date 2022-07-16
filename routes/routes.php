<?php

use Descom\AuthSpa\Http\Controllers\LoginController;
use Descom\AuthSpa\Http\Controllers\LogoutController;
use Descom\AuthSpa\Http\Controllers\Passwords\ForgotPasswordController;
use Descom\AuthSpa\Http\Controllers\Passwords\ResetPasswordController;
use Descom\AuthSpa\Http\Controllers\Users\ProfileInfoController;
use Descom\AuthSpa\Http\Controllers\Users\UpdatePasswordController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class)
    ->middleware(['web'])
    ->name('login');

Route::post('/logout', LogoutController::class)
    ->middleware(['web'])
    ->name('logout');

Route::post('/password/forgot', ForgotPasswordController::class)
    ->middleware(['web'])
    ->name('password.forgot');

Route::post('/password/reset', ResetPasswordController::class)
    ->middleware(['web'])
    ->name('password.reset');

Route::group([
    'middleware' => config('auth_spa.http.profile_info.middleware', ['api', 'auth:sanctum'])
], function () {
    Route::put('/api/user/password', UpdatePasswordController::class)
        ->name('api.user.password.update');

    Route::get(
        config('auth_spa.http.profile_info.path',  '/api/user'),
        config('auth_spa.http.profile_info.controller',  ProfileInfoController::class)
    )->name('api.user.profile');
});
