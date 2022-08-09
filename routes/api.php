<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\AllProductsController;
use App\Http\Controllers\AdminProductsController;
use App\Http\Controllers\AdminOrdersController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AdminProductParametersController;

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
Route::post('login-admin', [SignController::class, 'adminLogin']);

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
    // admin login
    Route::get('get-auth-user-role', [SignController::class, 'getAuthUserRole']);
    // admin products
    Route::get('get-all-user-data', [AdminProductsController::class, 'getAllUserData']);
    Route::delete('/delete-users-product/{id}', [AdminProductsController::class, 'deleteUserProduct']);
    Route::post('update-user-product', [AdminProductsController::class, 'updateUserProduct']);
    // admin orders
    Route::get('get-all-ordered-products', [AdminOrdersController::class, 'getAllOrderedProducts']);
    Route::get('all-users', [AdminOrdersController::class, 'getAllUsers']);
    // admin users
    Route::get('get-all-users', [AdminUsersController::class, 'getUserList']);
    Route::get('/delete-users/{id}', [AdminUsersController::class, 'deleteUser']);
    Route::post('update-user', [AdminUsersController::class, 'updateUser']);
    // admin product parameters
    Route::post('add-category', [AdminProductParametersController::class, 'addCategory']);
    Route::get('get-product-categories', [AdminProductParametersController::class, 'getProductCategories']);
    Route::get('remove-category/{id}', [AdminProductParametersController::class, 'removeProductCategories']);
    Route::post('add-size', [AdminProductParametersController::class, 'addSize']);
    Route::get('get-product-sizes', [AdminProductParametersController::class, 'getProductSizes']);
    Route::get('remove-size/{id}', [AdminProductParametersController::class, 'removeProductSizes']);
});

// All products
Route::get('/get-all-user-products',  [AllProductsController::class, 'getAllUsersProducts']);
Route::get('/get-product-details/{id}',  [AllProductsController::class, 'getProductDetails']);
Route::post('/get-searched-product', [AllProductsController::class, 'searchProduct']);
Route::post('/get-guest-from-cart', [CartController::class, 'getGuestCartProducts']);
