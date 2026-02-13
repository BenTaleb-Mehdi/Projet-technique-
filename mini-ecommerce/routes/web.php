<?php
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', [HomeController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [HomeController::class, 'show'])->name('products.show');


Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');


Auth::routes();


Route::middleware(['auth', 'can:manage-products'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});