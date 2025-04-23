<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Models\Roles;
use App\Policies\RolesPolicy;
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Roles::class => RolesPolicy::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}
