<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\AllProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Sign
Route::post('register', [SignController::class, 'register']);
Route::post('login', [SignController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Sign
    Route::get('logout', [SignController::class, 'logOut']);
    // Products
    Route::post('create-product', [ProductController::class, 'createProduct']);
    Route::get('get-auth-user-products', [ProductController::class, 'getAuthUserProducts']);
    Route::delete('delete-auth-user-products/{id}', [ProductController::class, 'deleteAuthUserProducts']);
    Route::get('update-product-data/{id}', [ProductController::class, 'updateProductData']);
    Route::post('update-product', [ProductController::class, 'updateProduct']);
    // Profile
    Route::post('create-address', [UserInfoController::class, 'createAddress']);
    Route::get('get-user-data', [UserInfoController::class, 'getUserInfo']);
    Route::get('make-address-default/{id}', [UserInfoController::class, 'makeAddressDefault']);
    Route::delete('delete-address/{id}', [UserInfoController::class, 'deleteAddress']);
    Route::post('change-password', [UserInfoController::class, 'changePassword']);
});

// All products
Route::get('/get-all-user-products',  [AllProductsController::class, 'getAllUsersProducts']);
Route::get('/get-product-details/{id}',  [AllProductsController::class, 'getProductDetails']);
