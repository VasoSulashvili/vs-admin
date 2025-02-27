<?php

namespace VS\Admin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use VS\Admin\Http\Middleware\AdminAuth;

class VSAdminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerMiddleware();

        // Register the package's routes
        Route::prefix('api/admin')
            ->group(__DIR__ . '/../routes/api.php');


        // Register the package's migrations
        $this->loadMigrationsFrom(
            __DIR__ . '/../database/migrations'
        );
        // Merge the package's configuration
//        $this->mergeConfigFrom(
//            __DIR__ . '/../config/auth.php',
//            'auth'
//        );

    }

    protected function registerMiddleware()
    {
        // Register the middleware into Laravel's global middleware stack
        $this->app['router']->aliasMiddleware('auth.admin', AdminAuth::class);
    }



}
