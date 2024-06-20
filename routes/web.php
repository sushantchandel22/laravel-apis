<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
// Route::get('/', function () {
//     return view('cart');
// });
Route::get('/' ,function(){
    return view('User/signup');
} );
Route::get('/login' , function(){
    return view('User/login');
});

