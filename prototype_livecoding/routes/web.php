<?php
use App\Http\Controllers\admin\ProductController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;



  
Route::get('/', [ProductController::class, 'index'])->name('admin.partials.index');
Route::post('/admin/partials/store', [ProductController::class, 'store'])->name('products.store');

  




