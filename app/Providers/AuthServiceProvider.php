<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin', function(User $user){
            return $user->role == 'admin';
        });
        
        Gate::define('nvkho', function(User $user){
            return $user->role == 'nvkho' || $user->role == 'admin';
        });
        
        Gate::define('nvbanhang', function(User $user){
            return $user->role == 'nvbanhang' || $user->role == 'admin';
        });

        Gate::define('nvthungan', function(User $user){
            return $user->role == 'nvthungan' || $user->role == 'admin';
        });
    }
}
