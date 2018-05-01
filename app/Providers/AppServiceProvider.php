<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
     protected $policies = [
       //'App\Model' => 'App\Policies\ModelPolicy',
       //Post::class => PostPolicy::class
       //'App\Models\User' => 'App\Policies\UserPolicy'
       User::class => UserPolicy::class,
     ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Schema::defaultStringLength(191); //fix old sql version according to laravel doc 5.6
        $this->registerPolicies();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
