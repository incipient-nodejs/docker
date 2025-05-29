<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/terms', [MainController::class, 'terms'])->name('terms');
Route::match(['get', 'post'], '/privacy', [MainController::class, 'privacy'])->name('privacy');
Route::match(['get', 'post'], '/delete-data', [MainController::class, 'deleteData'])->name('delete-data');
Route::get('/privacy-Policy',function(){
    return view('privacy-policy');
});