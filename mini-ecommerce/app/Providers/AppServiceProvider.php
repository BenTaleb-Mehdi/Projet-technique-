<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // Import Gate
use App\Models\User; // Import User Model

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate for general management (Both Admin and Seller)
        Gate::define('manage-products', function (User $user) {
            return in_array($user->role, ['admin', 'seller']);
        });

        // Gate for deletion (ONLY Admin)
        Gate::define('delete-product', function (User $user) {
            return $user->role === 'admin';
        });
    }
}