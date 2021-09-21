<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
// use Symfony\Component\HttpFoundation\Session\Session;
Route::get('/login', function () {
    return view('login');
});
Route::post('login' , [UserController::class, 'login']);
Route::get('/' , [ProductController::class, 'index']);
Route::get('/details/{id}' , [ProductController::class, 'details']);
Route::get('search' , [ProductController::class, 'search']);

Route::post('add_to_cart' , [ProductController::class, 'addtocart']);
Route::get('/logout', function () {
    Session::forget('user');
    return redirect('/login');
});
Route::get("cartlist",[ProductController::class, 'cartlist']);
Route::view('/register', 'register');
Route::post("register",[UserController::class,'register']);
Route::get("ordernow",[ProductController::class, 'orderNow']);



