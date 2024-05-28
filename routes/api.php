<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('login',[UserController::class , 'login'])->name('login');


Route::middleware(['api','auth:api'])->group(function () {
    Route::get('loggedin', [UserController::class, 'loggedIn'])->name('loggedin');
    Route::apiResource('users', UserController::class);
});
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products' , ProductController::class);