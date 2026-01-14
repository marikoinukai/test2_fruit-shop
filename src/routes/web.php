<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::model('productId', Product::class);
Route::get('/products/detail/{productId}', [ProductController::class, 'show'])->name('products.show');


// 登録
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

// 更新
Route::get('/products/{productId}/update', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/products/{productId}/update', [ProductController::class, 'update'])->name('products.update');

// 削除
Route::post('/products/{productId}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
