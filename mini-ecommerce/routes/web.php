<?php
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


Route::get('/', [HomeController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [HomeController::class, 'show'])
    ->name('products.show');
  
Route::get('/admin', [ProductController::class, 'index'])->name('admin.partials.index');
Route::post('/admin/products/store', [ProductController::class, 'store'])->name('products.store');
Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

  Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');




