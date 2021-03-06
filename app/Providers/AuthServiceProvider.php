<?php

namespace App\Providers;

use App\Providers\Auth\GoogleOAuthProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Will register 'googleauth' a custom user provider that validates Google OAuth ID tokens for 
 * our API. These tokens are made after a user logs into Google for authorization.
 * On custom user providers: https://laravel.com/docs/5.4/authentication#adding-custom-user-providers
 * 
 */
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

        Auth::provider('googleoauth', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return new GoogleOAuthProvider();
        });
        //
    }
}
