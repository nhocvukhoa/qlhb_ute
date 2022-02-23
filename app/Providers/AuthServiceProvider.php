<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //ctsv, cbk, member

        Gate::define('ctsv', function ($user) {
            return $user->quyen == 0;
        });

        Gate::define('cbk', function ($user) {
            return $user->quyen == 1;
        });

        Gate::define('sv', function ($user) {
            return $user->quyen == 2;
        });

        Gate::define('ntt', function ($user) {
            return $user->quyen == 3;
        });
    }
}
