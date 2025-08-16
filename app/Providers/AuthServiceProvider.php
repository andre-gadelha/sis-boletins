<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        //verifica se o usuário é administrador, administrador de boletins ou administrador de usuários
        Gate::define('is_admin', function($_user){
            return $_user->profile == "administrator" ? true : false;
        });

        Gate::define('is_admin_bol', function($_user){
            return $_user->profile == "adminBoletins" ? true : false;
        });

        Gate::define('is_admin_bol', function($_user){
            return $_user->profile == "adminUsuarios" ? true : false;
        });

        Gate::define('is_admin_or_admin_bol', function($_user){
            $allowedProfiles = ["administrator", "adminBoletins"];
            return in_array($_user->profile, $allowedProfiles);
        });

        Gate::define('is_admin_or_admin_usu', function($_user){
            $allowedProfiles = ["administrator", "adminUsuarios"];
            return in_array($_user->profile, $allowedProfiles);
        });

        Gate::define('is_admin_all', function($_user){
            $allowedProfiles = ["administrator", "adminBoletins", "adminUsuarios"];
            return in_array($_user->profile, $allowedProfiles);
        });
        
        //verifica se o usuário está ativo
        Gate::define('is_active', function($_user){
            return $_user->status == "actived" ? true : false;
        });

    }
}
