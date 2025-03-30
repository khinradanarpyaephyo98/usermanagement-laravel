<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
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
        
        try {
            Permission::with('feature')->get()->each(function ($permission) {
                // Construct Gate name using feature and permission name directly
                $gateName = $permission->feature->name . '.' . $permission->name;

                Gate::define($gateName, function ($user) use ($permission) {
                    if ($user->role) {
                        return $user->role->permissions->contains($permission);
                    }
                    return false;
                });
            });
        } catch (\Exception $e) {
            // Handle database not ready scenario
        }
    }
}
