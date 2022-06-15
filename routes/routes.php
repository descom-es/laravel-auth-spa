<?php

use Descom\AuthSpa\Http\Controllers\LoginController;
use Descom\AuthSpa\Http\Controllers\LogoutController;
use Descom\AuthSpa\Http\Controllers\Passwords\ResetController;
use Descom\AuthSpa\Http\Controllers\Passwords\ResetLinkController;
use Descom\AuthSpa\Http\Controllers\UserController;
use Descom\AuthSpa\Http\Controllers\ProfileInfoController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['web']], function () {
    Route::post('login', LoginController::class)->name('login');
    Route::post('logout', LogoutController::class)->name('logout');
    Route::post('/password/reset_link', ResetLinkController::class)->name('password.reset_link');
    Route::post('/password/reset', ResetController::class)->name('password.reset');
});

Route::group(['middleware' => ['api', 'auth:sanctum']], function () {
    Route::get('user', config('auth_spa.controllers.user_info',  ProfileInfoController::class))
        ->name('profile.info');
});


Route::get(
    config('auth_spa.http.profile_info.path',  'user'),
    config('auth_spa.http.profile_info.controller',  ProfileInfoController::class)
)->middleware(config('auth_spa.http.profile_info.middleware', ['api', 'auth:sanctum']))
->name('profile.info');
