<?php

use Descom\AuthSpa\Http\Controllers\LoginController;
use Descom\AuthSpa\Http\Controllers\LogoutController;
use Descom\AuthSpa\Http\Controllers\ResetController;
use Descom\AuthSpa\Http\Controllers\ResetLinkController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['web']], function () {
    Route::post('login', LoginController::class)->name('login');
    // Route::post('logout', LogoutController::class)->name('logout');
    // Route::post('/password/forget', ResetLinkController::class)->name('password.forget');
    // Route::post('/password/reset', ResetController::class)->name('password.reset');
});

Route::group(['middleware' => ['api']], function () {
    // Route::get('user', InfoController::class)->middleware('auth')->name('api.user');
});
