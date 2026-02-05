<?php
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
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
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // 1. Common Actions (Both Admin and Seller can access these)
    Route::get('/', [ProductController::class, 'index'])->name('admin.index');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    // 2. RESTRICTED Actions (Only Admin)
    // We use the 'can' middleware which points directly to the Gate we defined earlier
    Route::middleware(['can:delete-product'])->group(function () {
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        
        // You can add more admin-only routes here later, like:
        // Route::get('/users', [UserController::class, 'index']);
    });
});

// Route::get('/home', [HomeController::class, 'index'])->name('home');