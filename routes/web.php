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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function () {
    Route::get('products', [App\Http\Controllers\ProductController::class, 'index'])->middleware('role:vendor|customer');
    Route::post('products', [App\Http\Controllers\ProductController::class, 'store'])->middleware('role:vendor');
    Route::get('products/create', [App\Http\Controllers\ProductController::class, 'create'])->middleware('role:vendor');
    Route::get('products/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->middleware('role:vendor');
    Route::get('products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->middleware('role:vendor|customer');
    Route::patch('products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->middleware('role:vendor');
    Route::delete('products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->middleware('role:vendor');
    Route::post('order/{productId}/{type}', [App\Http\Controllers\OrderController::class, 'updateOrder'])->middleware('role:customer');
});
