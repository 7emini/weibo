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

        //自动注册授权策略
        //TODO:权限系统 https://learnku.com/courses/laravel-essential-training/6.x/permissions-system/5484
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return 'App\Policies\\'.class_basename($modelClass).'Policy';
        });
    }
}
