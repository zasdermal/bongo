<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        foreach (glob(base_path('module/*/Migrations')) as $path) {
            $this->loadMigrationsFrom($path);
        }

        foreach (glob(base_path('module/*/routes.php')) as $routeFile) {
            require $routeFile;
        }

        foreach (glob(base_path('module/*/Views')) as $viewPath) {
            $this->loadViewsFrom($viewPath, basename(dirname($viewPath)));
        }
    }
}
