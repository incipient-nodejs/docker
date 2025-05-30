
<?php

use Illuminate\Support\Facades\Route;


Route::post('/login/web', [App\Http\Controltudkabirlers\Web\v1\UserController::class, 'login']);
Route::post('/web/otp', [App\Http\Controllers\Web\v1\UserController::class, 'sendOTPForgetPassword']);
Route::get('/web/otp', [App\Http\Controllers\Web\v1\UserController::class, 'verifyOtp']);
Route::put('user/web/reset-password', [App\Http\Controllers\Web\v1\UserController::class, 'ResetPassword']);
Route::get('/web/category-and-product-list', [App\Http\Controllers\Web\v1\HomePageNotSignController::class, 'ProductsAndServices']);
Route::get('/healthz', function () {
    dd('ok');
});



