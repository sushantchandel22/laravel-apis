<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login',[UserController::class , 'login']);
Route::post('/signup' , [UserController::class , 'store']);
Route::post('/updatedata' , [UserController::class , 'store']);
Route::middleware(['api','auth:api'])->group(function () {
    Route::get('/loggedin', [UserController::class, 'getUser'])->name('loggedin');
    Route::apiResource('/users', UserController::class);
    Route::apiResource('products' , ProductController::class);
   
});
Route::apiResource('carts' , CartController::class);
Route::apiResource('categories', CategoryController::class);
