<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/products', [ProductController::class, 'products'])->name('product');
Route::get('/products/add', [ProductController::class, 'productAdd'])->name('product-add');
Route::post('/store', [ProductController::class, 'store'])->name('product.store');
Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
// Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::get('products/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
Route::get('purchases', [PurchaseController::class, 'purchases'])->name('purchase');
Route::get('purchases/add', [PurchaseController::class, 'purchasesAdd'])->name('purchase.add');
Route::post('purchases/store', [PurchaseController::class, 'store'])->name('purchase.store');
Route::get('purchases/edit/{id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
Route::put('purchases/update/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
Route::get('purchases/detail/{id}', [PurchaseController::class, 'detail'])->name('purchase.detail');
Route::delete('purchases/delete/{id}', [PurchaseController::class, 'delete'])->name('purchase.delete');
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::get('/supplier', [SupplierController::class, 'supplier'])->name('supplier');





