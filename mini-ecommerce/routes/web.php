<?php
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


Route::get('/', [HomeController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [HomeController::class, 'show'])
    ->name('products.show');
  
Route::get('/admin', [ProductController::class, 'index'])->name('admin.products.index');
Route::post('/admin/products/store', [ProductController::class, 'store'])->name('products.store');

  




