<?php

use Illuminate\Support\Facades\Route;

Route::get('/banned-terms/page', [App\Http\Controllers\Api\v1\BannedTermsController::class, 'page']);
Route::get('/rating-services/page', [App\Http\Controllers\Api\v1\RatingServiceController::class, 'page']);
Route::get('/rating-products/page', [App\Http\Controllers\Api\v1\RatingProductController::class, 'page']);
Route::get('/delete-accounts/page', [App\Http\Controllers\Api\v1\DeleteAccountController::class, 'page']);
Route::get('/business-details/page', [App\Http\Controllers\Api\v1\BusinessDetailController::class, 'page']);
Route::get('/informal-types/page', [App\Http\Controllers\Api\v1\InformalTypeController::class, 'page']);
Route::get('/personal-data/page', [App\Http\Controllers\Api\v1\PersonalDataController::class, 'page']);
Route::get('/company-data/page', [App\Http\Controllers\Api\v1\CompanyDataController::class, 'page']);
Route::get('/formal-types/page', [App\Http\Controllers\Api\v1\FormalTypeController::class, 'page']);
Route::get('/categories/page', [App\Http\Controllers\Api\v1\CategoryController::class, 'page']);
Route::get('/user-types/page', [App\Http\Controllers\Api\v1\UserTypeController::class, 'page']);
Route::get('/products/page', [App\Http\Controllers\Api\v1\ProductController::class, 'page']);
Route::get('/services/page', [App\Http\Controllers\Api\v1\ServiceController::class, 'page']);
Route::get('/websites/page', [App\Http\Controllers\Api\v1\WebsiteController::class, 'page']);
Route::get('/comments/page', [App\Http\Controllers\Api\v1\CommentController::class, 'page']);
Route::get('/users/page', [App\Http\Controllers\Api\v1\UserController::class, 'page']);

