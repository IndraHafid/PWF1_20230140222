<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Product' => 'App\Policies\ProductPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate untuk manage product (admin only)
        Gate::define('manage-product', function ($user) {
            return $user->role === 'admin';
        });

        // Gate untuk export product (admin only) - untuk Kelas B
        Gate::define('export-product', function ($user) {
            return $user->role === 'admin';
        });
    }
}
