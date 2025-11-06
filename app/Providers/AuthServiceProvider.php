<?php

namespace App\Providers;

// use App\Domains\Users\Models\User as DomainUser;
// use App\Domains\Users\Policies\UserPolicy;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // DomainUser::class => UserPolicy::class,
    ];

    public function boot()
    {
        Route::aliasMiddleware('auth.admin', \App\Http\Middleware\RedirectIfNotAdmin::class);
        // $this->registerPolicies();
        // Gate::before(function ($user, $ability) {
        //     return $user->hasRole('super-admin') ? true : null;
        // });
    }

}
