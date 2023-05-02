<?php

namespace App\Providers;

use App\Users\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $isAdmin = function (User $user) {
            return $user->isAdmin();
        };

        $isSeller = function (User $user) {
            return $user->isSeller();
        };

        $isSellerOrAdmin = function (User $user) {
            return $user->isSeller() || $user->isAdmin();
        };


        Gate::define('admin', $isAdmin);
        Gate::define('seller', $isSeller);

        Gate::define('crud-sellers', $isAdmin);

        Gate::define('read-create-edit-clients', $isSellerOrAdmin);
        Gate::define('delete-clients', $isAdmin);

        Gate::define('read-create-edit-deals', $isSellerOrAdmin);
        Gate::define('delete-deals', $isAdmin);
    }
}
