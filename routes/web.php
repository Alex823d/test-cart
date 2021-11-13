<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cart',[\App\Http\Controllers\Test_cart_controller::class, 'getUserCart']);
Route::post('/add_cart',[\App\Http\Controllers\Test_cart_controller::class, 'addProductInCart']);
Route::post('/edit_cart',[\App\Http\Controllers\Test_cart_controller::class, 'setCartProductQuantity']);
Route::post('/delete_cart',[\App\Http\Controllers\Test_cart_controller::class, 'removeProductFromCart']);
