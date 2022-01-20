<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;




class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
        /**
         * Implicitly grant Super Admin role all permissions.
         * This works in the app by using gate-related function 
         * like: auth()->user->can() and in @can()
         */
        Gate::before(function($user,$ability){
            return $this->hasRole('super-admin') ? true : null;
        });
        
    }
}
