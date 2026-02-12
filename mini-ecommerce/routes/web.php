<?php
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', [HomeController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [HomeController::class, 'show'])->name('products.show');

// --- Language Switcher ---
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// --- Authentication ---
Auth::routes();

// --- Protected Admin/Seller Area ---
// Zdna 'as' bach les noms dial les routes y-bdaw b 'admin.'
Route::middleware(['auth', 'role:admin|seller'])->prefix('admin')->as('admin.')->group(function () {

    // Common Actions (Admin & Seller)
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});