<?php

use App\Http\Controllers\{CartController ,CategoryController,ProductController ,UserController};

use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::post('/login','login');
    Route::post('/signup','store');
    Route::post('/updatedata','store');
});


Route::middleware(['api', 'auth:api'])->group(function () {
    Route::get('/loggedin', [UserController::class, 'getUser'])->name('loggedin');
    Route::apiResource('/users', UserController::class);
    Route::apiResource('products', ProductController::class);
    Route::delete('deleteimage/{id}', [ProductController::class, 'deleteProductImage']);
    Route::get('category/products ', [ProductController::class, 'getProductByCategory']);
    Route::post('updateproducts/{id}', [ProductController::class, 'updateProduct']);
    Route::get('categoryproduct', [CategoryController::class, 'getProductByCategory']);
    Route::delete('/carts/{cartId}/products/{productId}', [CartController::class, 'deleteProductFromCart']);
    Route::apiResource('carts', CartController::class);
    Route::apiResource('categories', CategoryController::class);
});

