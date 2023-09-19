<?php

use Descom\AuthSpa\Http\Controllers\LoginController;
use Descom\AuthSpa\Http\Controllers\LogoutController;
use Descom\AuthSpa\Http\Controllers\Passwords\ForgotPasswordController;
use Descom\AuthSpa\Http\Controllers\Passwords\ResetPasswordController;
use Descom\AuthSpa\Http\Controllers\Users\ProfileInfoController;
use Descom\AuthSpa\Http\Controllers\Users\UpdatePasswordController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::group(['middleware' => ['web']], function () {
    Route::post('/login', LoginController::class)
        ->middleware(['guest'])
        ->name('login');

    Route::post('/password/forgot', ForgotPasswordController::class)
        ->middleware(['guest'])
        ->name('password.forgot');

    Route::post('/password/reset', ResetPasswordController::class)
        ->middleware(['guest'])
        ->name('password.reset');

    Route::post('/logout', LogoutController::class)
        ->middleware(['auth'])
        ->name('logout');
});


Route::group(['middleware' => [
    'api',
    'auth',
    EnsureFrontendRequestsAreStateful::class,
]], function () {
    Route::put('/api/user/password', UpdatePasswordController::class)
        ->name('api.user.password.update');

    Route::get('/api/user', ProfileInfoController::class)
    ->name('api.user.profile');
});
