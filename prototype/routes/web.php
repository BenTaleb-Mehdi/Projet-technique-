<?php
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;



  
Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
Route::post('/admin/products/store', [ProductController::class, 'store'])->name('products.store');
Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');

  




