<?php

namespace VS\Admin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use VS\Admin\Http\Middleware\AdminAuth;
use Illuminate\Auth\Notifications\ResetPassword;
use VS\Admin\Models\Admin;

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

        // Reset Password Link
        ResetPassword::createUrlUsing(function (Admin $user, string $token) {
            return 'https://example.com/reset-password?token='.$token;
        });

        // Register the package's routes
        Route::prefix('api/admin')
            ->middleware('api')
            ->as('api.vs.admin.')
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
        $this->app['router']->aliasMiddleware('auth.admin', AdminAuth::class);
    }



}
