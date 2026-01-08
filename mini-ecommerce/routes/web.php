<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


Route::get('/', [HomeController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [HomeController::class, 'show'])
    ->name('products.show');

  




