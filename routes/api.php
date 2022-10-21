<?php

use App\Http\Controllers\CommentsController;
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
use App\Http\Controllers\SavedForLaterController;
use App\Http\Controllers\MessagesController;

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
Route::get('verify/{token}', [SignController::class, 'verify']);
Route::post('login', [SignController::class, 'login']);
Route::post('register', [SignController::class, 'register']);
Route::post('login-admin', [SignController::class, 'adminLogin']);

Route::middleware('auth:sanctum')->group(function () {
    // Sign
    Route::get('logout', [SignController::class, 'logOut']);
    // Products
    Route::get('publish-product/{id}', [ProductController::class, 'publishProduct']);
    Route::get('get-auth-user-products', [ProductController::class, 'getAuthUserProducts']);
    Route::get('update-product-data/{id}', [ProductController::class, 'updateProductData']);
    Route::get('get-product-subcategories/{categoryName}', [ProductController::class, 'getSubcategories']);
    Route::get('get-products-likes/{id}', [ProductController::class, 'getProductLike']);
    Route::get('like-products/{id}', [ProductController::class, 'likeProduct']);
    Route::get('unlike-products/{id}', [ProductController::class, 'unlikeProduct']);
    Route::post('update-product', [ProductController::class, 'updateProduct']);
    Route::post('create-product', [ProductController::class, 'createProduct']);
    Route::delete('delete-product-image/{id}', [ProductController::class, 'deleteProductImage']);
    Route::delete('delete-auth-user-products/{id}', [ProductController::class, 'deleteAuthUserProducts']);
    // Comments
    Route::get('get-products-comments/{id}', [CommentsController::class, 'getProductComments']);
    Route::get('like-products-comments/{id}', [CommentsController::class, 'likeProductComments']);
    Route::get('dislike-products-comments/{id}', [CommentsController::class, 'dislikeProductComments']);
    Route::post('create-product-comment', [CommentsController::class, 'createProductComment']);
    Route::delete('delete-product-comment/{id}', [CommentsController::class, 'deleteProductComment']);
    // Profile
    Route::get('get-user-data', [UserInfoController::class, 'getUserInfo']);
    Route::get('make-address-default/{id}', [UserInfoController::class, 'makeAddressDefault']);
    Route::post('create-address', [UserInfoController::class, 'createAddress']);
    Route::post('change-password', [UserInfoController::class, 'changePassword']);
    Route::delete('delete-address/{id}', [UserInfoController::class, 'deleteAddress']);
    // cart
    Route::get('/get-from-cart', [CartController::class, 'getFromCart']);
    Route::get('/add-product/{id}', [CartController::class, 'addCount']);
    Route::get('/reduce-product/{id}', [CartController::class, 'reduceCount']);
    Route::get('/add-to-cart/{id}/{count}', [CartController::class, 'addToCart']);
    Route::get('/remove-from-cart/{id}', [CartController::class, 'removeFromCart']);
    // ordering
    Route::get('/buy-products-from-cart', [CartController::class, 'buyProductsFromCart']);
    Route::get('/get-ordered', [CartController::class, 'getOrderedProducts']);
    // save for later
    Route::get('/get-saved-for-later', [SavedForLaterController::class, 'getSaveForLater']);
    Route::get('/save-product-for-later/{id}', [SavedForLaterController::class, 'saveForLater']);
    Route::delete('/remove-product-from-save-for-later/{id}', [SavedForLaterController::class, 'removeSaveForLater']);
    // messages
    Route::get('/get-chat-messages', [MessagesController::class, 'getChatMessages']);
    Route::get('/get-chosen-user-messages/{id}', [MessagesController::class, 'chosenUsersMessages']);
    Route::post('create-message/{id}', [MessagesController::class, 'createMessage']);
    // admin login
    Route::get('get-auth-user-role', [SignController::class, 'getAuthUserRole']);
    // admin products
    Route::get('get-all-user-data', [AdminProductsController::class, 'getAllUserData']);
    Route::post('update-user-product', [AdminProductsController::class, 'updateUserProduct']);
    Route::delete('/delete-users-product/{id}', [AdminProductsController::class, 'deleteUserProduct']);
    // admin orders
    Route::get('all-users', [AdminOrdersController::class, 'getAllUsers']);
    Route::get('get-all-ordered-products', [AdminOrdersController::class, 'getAllOrderedProducts']);
    // admin users
    Route::get('get-all-users', [AdminUsersController::class, 'getUserList']);
    Route::get('/delete-users/{id}', [AdminUsersController::class, 'deleteUser']);
    Route::post('update-user', [AdminUsersController::class, 'updateUser']);
    // admin product parameters
    Route::get('get-product-sizes', [AdminProductParametersController::class, 'getProductSizes']);
    Route::get('remove-size/{id}', [AdminProductParametersController::class, 'removeProductSizes']);
    Route::get('get-product-categories', [AdminProductParametersController::class, 'getProductCategories']);
    Route::get('remove-category/{id}', [AdminProductParametersController::class, 'removeProductCategories']);
    Route::get('remove-subcategory/{id}', [AdminProductParametersController::class, 'removeProductSubCategories']);
    Route::get('get-product-subcategories', [AdminProductParametersController::class, 'getProductSubCategories']);
    Route::post('add-size', [AdminProductParametersController::class, 'addSize']);
    Route::post('add-category', [AdminProductParametersController::class, 'addCategory']);
    Route::post('add-subcategory', [AdminProductParametersController::class, 'addSubCategory']);
});

// All products
Route::get('/get-all-user-products',  [AllProductsController::class, 'getAllUsersProducts']);
Route::get('/get-product-details/{id}',  [AllProductsController::class, 'getProductDetails']);
Route::post('/get-searched-product', [AllProductsController::class, 'searchProduct']);
Route::post('/get-guest-from-cart', [CartController::class, 'getGuestCartProducts']);
Route::post('get-guest-saved-for-later-products', [SavedForLaterController::class, 'getGuestSavedForLaterProducts']);

