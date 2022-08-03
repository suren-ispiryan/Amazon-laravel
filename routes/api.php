<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignController;
use App\Http\Controllers\CartController;
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
    // cart
    Route::get('/add-to-cart/{id}/{count}', [CartController::class, 'addToCart']);
    Route::get('/get-from-cart', [CartController::class, 'getFromCart']);
    Route::get('/remove-from-cart/{id}', [CartController::class, 'removeFromCart']);
    Route::get('/reduce-product/{id}', [CartController::class, 'reduceCount']);
    Route::get('/add-product/{id}', [CartController::class, 'addCount']);
    // ordering
    Route::get('/buy-products-from-cart', [CartController::class, 'buyProductsFromCart']);
    Route::get('/get-ordered', [CartController::class, 'getOrderedProducts']);
});

// All products
Route::get('/get-all-user-products',  [AllProductsController::class, 'getAllUsersProducts']);
Route::get('/get-product-details/{id}',  [AllProductsController::class, 'getProductDetails']);
Route::post('/get-searched-product', [AllProductsController::class, 'searchProduct']);
Route::post('/get-guest-from-cart', [CartController::class, 'getGuestCartProducts']);
