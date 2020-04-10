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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Creating Gates for roles
        //Creating a Gate for the giver
        Gate::define('giver-role', function($user){
            return $user->hasRole('giver');
        });

        //Creating a Gate for the applicant
        Gate::define('applicant-role', function($user){
            return $user->hasRole('applicant');
        }); 
        
        //Creating a Gate for the delivery-man
        Gate::define('delivery-man-role', function($user){
            return $user->hasRole('delivery-man');
        }); 

        //Creating a Gate for the admin-role
        Gate::define('admin-role', function($user){
            return $user->hasRole('admin');
        });
        

        //functionalities
        //Manage Users Gate 
        Gate::define('manage-users', function($user){
            return $user->hasRole('admin');
        });
        
        //$user wich is passed a a parametre is the current logged in user !!!
        Gate::define('edit-users', function($user){
            return $user->hasRole('admin');
        });

        //Gate pour la suppression
        Gate::define('delete-users', function($user){
            return $user->hasRole('admin');
        });
    }
}
