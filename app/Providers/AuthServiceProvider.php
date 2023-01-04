<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->defineCategoryPolicy();
        $this->defineProductPolicy();

    }

    public function defineCategoryPolicy()
    {
        Gate::define('category-list',[CategoryPolicy::class,'view']);
        Gate::define('category-add',[CategoryPolicy::class,'create']);
        Gate::define('category-edit',[CategoryPolicy::class,'update']);
        Gate::define('category-delete',[CategoryPolicy::class,'delete']);
    }

    public function defineProductPolicy()
    {
        Gate::define('product-list', function (User $user){
            return $user->checkPermissionAccess(config('permissions.access.list-product'));
        });
        Gate::define('product-add', function (User $user){
            return $user->checkPermissionAccess('product_add');
        });
        Gate::define('product-edit', [ProductPolicy::class, 'update']);
    }
}
