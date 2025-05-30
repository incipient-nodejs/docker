<?php

use Illuminate\Support\Facades\Route;

Route::get('/business-details/search', [App\Http\Controllers\Api\v1\BusinessDetailController::class, 'search']);
Route::get('/informal-types/search', [App\Http\Controllers\Api\v1\InformalTypeController::class, 'search']);
Route::get('/personal-data/search', [App\Http\Controllers\Api\v1\PersonalDataController::class, 'search']);
Route::get('/company-data/search', [App\Http\Controllers\Api\v1\CompanyDataController::class, 'search']);
Route::get('/formal-types/search', [App\Http\Controllers\Api\v1\FormalTypeController::class, 'search']);
Route::get('/categories/search', [App\Http\Controllers\Api\v1\CategoryController::class, 'search']);
Route::get('/user-types/search', [App\Http\Controllers\Api\v1\UserTypeController::class, 'search']);
Route::get('/products/search', [App\Http\Controllers\Api\v1\ProductController::class, 'search']);
Route::get('/services/search', [App\Http\Controllers\Api\v1\ServiceController::class, 'search']);
Route::get('/websites/search', [App\Http\Controllers\Api\v1\WebsiteController::class, 'search']);
Route::get('/users/search', [App\Http\Controllers\Api\v1\UserController::class, 'search']);
