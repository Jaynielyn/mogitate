<?php

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

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');
// 商品詳細
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
// 商品編集
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
// 商品更新
Route::post('/products/{productId}/update', [ProductController::class, 'update'])->name('products.update');
// 商品削除
Route::post('/products/{productId}/delete', [ProductController::class, 'delete'])->name('products.delete');
