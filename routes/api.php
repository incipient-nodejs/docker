<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Api\v1\GridSettingController;

Route::get('/asyc-product', function (Request $request) {
  \App\Jobs\SyncProductsFromEndpoint::dispatch();
  return "Ok, vou trabalhar";
 });

Route::get("/healthz", function () {
    return response()->json(['status' => 'ok']);
});
Route::get('/user', function (Request $request) { return $request->user(); })->middleware('auth:sanctum');
Route::post('/logs', [LogController::class, 'store']);

Route::prefix('v1')->group(function(){
    Route::post('/users/exist-by-phone', [App\Http\Controllers\Api\v1\UserController::class, 'existByPhone']);

    require  __DIR__.'/api/search.php';
    require  __DIR__.'/api/page.php';
    require  __DIR__.'/api/web.php';

    Route::get('/rating-products/get-view/{id}', [App\Http\Controllers\Api\v1\RatingProductController::class, 'countProduct']);
    Route::get('/company-data/counter-view/{id}', [App\Http\Controllers\Api\v1\CompanyDataController::class, 'counterView']);

    Route::get('/products/company-view/{id}', [App\Http\Controllers\Api\v1\ProductController::class, 'totalByCompany']);
    Route::get('/products/user-view/{id}', [App\Http\Controllers\Api\v1\ProductController::class, 'totalByUser']);
    Route::get('/products/counter-view/{id}', [App\Http\Controllers\Api\v1\ProductController::class, 'counterView']);

    Route::get('/user-contact-counters/get-company-count/{id}', [App\Http\Controllers\Api\v1\UserContactCounterController::class, 'getCompanyCount']);
    Route::get('/user-contact-counters/get-week/{id}', [App\Http\Controllers\Api\v1\UserContactCounterController::class, 'getWeek']);
    Route::get('/user-contact-counters/get-user/{id}', [App\Http\Controllers\Api\v1\UserContactCounterController::class, 'getUser']);
    Route::post('/user-contact-counters', [App\Http\Controllers\Api\v1\UserContactCounterController::class, 'store']);

    Route::apiResource('grid-settings', GridSettingController::class);

    Route::post('/users/forget-recover-password', [App\Http\Controllers\Api\v1\RecoverPasswordController::class, 'recover']);

    Route::post('/users/{id}/updateMobile', [App\Http\Controllers\Api\v1\UserController::class, 'updateMobile']);
    Route::put('/users/{id}/updateMobile', [App\Http\Controllers\Api\v1\UserController::class, 'updateMobile']);
    Route::post('/users/{id}/updatePassword', [App\Http\Controllers\Api\v1\UserController::class, 'updatePassword']);
    Route::put('/users/{id}/updatePassword', [App\Http\Controllers\Api\v1\UserController::class, 'updatePassword']);

    Route::post('/sms-opt', [App\Http\Controllers\Api\v1\SmsController::class, 'sendOTP']);
    Route::post('/sms-opt-forget', [App\Http\Controllers\Api\v1\SmsController::class, 'sendOTPForgetPassword']);
    Route::post('/company-data/updateMobile', [App\Http\Controllers\Api\v1\CompanyDataController::class, 'updateMobile']);

    Route::post('/integration-wordpress', [App\Http\Controllers\Api\v1\IntegrationWordPressController::class, 'create']);
    Route::post('/integration-shopify', [App\Http\Controllers\Api\v1\IntegrationShopifyController::class, 'create']);
    Route::post('/integration-root', [App\Http\Controllers\Api\v1\IntegrationRootController::class, 'create']);

    Route::post('/informal-types/store-mob', [App\Http\Controllers\Api\v1\InformalTypeController::class, 'storeMobile']);
    Route::post('/formal-types/store-mob', [App\Http\Controllers\Api\v1\FormalTypeController::class, 'storeMobile']);

    Route::get('/banners/find-by-screen-all-produtos', [App\Http\Controllers\Api\v1\BannerController::class, 'getBannersByScreenProdutos']);
    Route::get('/banners/find-by-screen-vertical/{screen}', [App\Http\Controllers\Api\v1\BannerController::class, 'getBannersByScreenVertical']);
    Route::get('/banners/find-by-screen/{screen}', [App\Http\Controllers\Api\v1\BannerController::class, 'getBannersByScreen']);
    Route::get('/product-service/find-by-user/{id}', [App\Http\Controllers\Api\v1\ProductServiceController::class, 'getProductAndService']);
    Route::get('/products/suppliers', [App\Http\Controllers\Api\v1\ProductController::class, 'suppliers']);

    Route::get('/products/suppliers/search/{search}', [App\Http\Controllers\Api\v1\ProductController::class, 'supplierSearch']);
    Route::get('/products/search/{search}', [App\Http\Controllers\Api\v1\ProductController::class, 'search']);
    Route::get('/services/search/{search}', [App\Http\Controllers\Api\v1\ServiceController::class, 'search']);

    Route::post('/company-data/{id}', [App\Http\Controllers\Api\v1\CompanyDataController::class, 'update']);
    Route::post('/products/{id}', [App\Http\Controllers\Api\v1\ProductController::class, 'update']);
    Route::post('/services/{id}', [App\Http\Controllers\Api\v1\ServiceController::class, 'update']);
    Route::post('/users/{id}', [App\Http\Controllers\Api\v1\UserController::class, 'update']);

    Route::post('/register', [App\Http\Controllers\Api\v1\RegisterController::class, 'create']);
    Route::post('/login', [App\Http\Controllers\Api\v1\LoginController::class, 'authentication']);

    Route::get('/list/product', [App\Http\Controllers\Api\v1\SearchController::class, 'listProduct']);
    Route::get('/search/product/{text}', [App\Http\Controllers\Api\v1\SearchController::class, 'searchProduct']);
    Route::get('/search/service/{text}', [App\Http\Controllers\Api\v1\SearchController::class, 'searchService']);

    Route::get('/products/find-by-category/{id}', [App\Http\Controllers\Api\v1\ProductController::class, 'paginateCategory']);
    Route::get('/services/find-by-category/{id}', [App\Http\Controllers\Api\v1\ServiceController::class,'paginateCategory']);
    Route::get('/products/similar', [App\Http\Controllers\Api\v1\ProductController::class, 'similarProducts']);
    Route::get('/products/compare', [App\Http\Controllers\Api\v1\ProductController::class, 'compareProducts']);
    Route::get('/product-service-filter', [App\Http\Controllers\Api\v1\ProductController::class, 'productServiceFilter']);
    Route::get('/get-user-rating-for-product', [App\Http\Controllers\Api\v1\RatingProductController::class, 'getUserRatingForProduct']);
    Route::get('/get-user-rating-for-service', [App\Http\Controllers\Api\v1\RatingServiceController::class, 'getUserRatingForService']);

    Route::get('/categories/suppliers', [App\Http\Controllers\Api\v1\CategoryController::class, 'findAllSupplier']);
    Route::get('/categories/products', [App\Http\Controllers\Api\v1\CategoryController::class, 'findAllProduct']);
    Route::get('/categories/services', [App\Http\Controllers\Api\v1\CategoryController::class,'findAllService']);
    Route::post('/favorites/store', [App\Http\Controllers\Api\v1\FavoriteController::class, 'store']);
    Route::get('/favorites/search/{user_id}', [App\Http\Controllers\Api\v1\FavoriteController::class, 'getFavorites']);
    Route::delete('/favorites/delete/{item_id}', [App\Http\Controllers\Api\v1\FavoriteController::class, 'destroy']);

    Route::apiResources([
        'user/web' => App\Http\Controllers\Web\v1\UserController::class,
        'banned-terms' => App\Http\Controllers\Api\v1\BannedTermsController::class,
        'rating-services' => App\Http\Controllers\Api\v1\RatingServiceController::class,
        'rating-products' => App\Http\Controllers\Api\v1\RatingProductController::class,
        'delete-accounts' => App\Http\Controllers\Api\v1\DeleteAccountController::class,
        'business-details' => App\Http\Controllers\Api\v1\BusinessDetailController::class,
        'informal-types' => App\Http\Controllers\Api\v1\InformalTypeController::class,
        'personal-data' => App\Http\Controllers\Api\v1\PersonalDataController::class,
        'company-data' => App\Http\Controllers\Api\v1\CompanyDataController::class,
        'formal-types' => App\Http\Controllers\Api\v1\FormalTypeController::class,
        'user-types' => App\Http\Controllers\Api\v1\UserTypeController::class,
        'categories' => App\Http\Controllers\Api\v1\CategoryController::class,
        'services' => App\Http\Controllers\Api\v1\ServiceController::class,
        'products' => App\Http\Controllers\Api\v1\ProductController::class,
        'websites' => App\Http\Controllers\Api\v1\WebsiteController::class,
        'comments' => App\Http\Controllers\Api\v1\CommentController::class,
        'banners' => App\Http\Controllers\Api\v1\BannerController::class,
        'users' => App\Http\Controllers\Api\v1\UserController::class,
    ], ['names' => false]);

    Route::get('/privacy-Policy',function(){
        return view('privacy-policy');
    });
});

