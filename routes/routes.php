<?php

use Descom\AuthSpa\Http\Controllers\LoginController;
use Descom\AuthSpa\Http\Controllers\LogoutController;
use Descom\AuthSpa\Http\Controllers\Passwords\ResetController;
use Descom\AuthSpa\Http\Controllers\Passwords\ResetLinkController;
use Descom\AuthSpa\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['web']], function () {
    Route::post('login', LoginController::class)->name('login');
    Route::post('logout', LogoutController::class)->name('logout');
    Route::post('/password/reset_link', ResetLinkController::class)->name('password.reset_link');
    Route::post('/password/reset', ResetController::class)->name('password.reset');
});

Route::group(['middleware' => ['api', 'auth:sanctum']], function () {
    Route::get('user', [UserController::class, 'show'])->name('api.user');
});
