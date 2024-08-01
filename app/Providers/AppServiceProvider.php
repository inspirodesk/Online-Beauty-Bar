<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

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
        Paginator::useBootstrapFive();

        View::composer('layouts.nav', function ($view) {
            $settings = Setting::findOrFail(1);

            // Pass the retrieved values to the navigation Blade view
            $view->with('setting', $settings);
        });

        View::composer('layouts.app', function ($view) {
            $settings = Setting::findOrFail(1);

            // Pass the retrieved values to the navigation Blade view
            $view->with('setting', $settings);
        });

        View::composer('layouts.auth', function ($view) {
            $settings = Setting::findOrFail(1);

            // Pass the retrieved values to the navigation Blade view
            $view->with('setting', $settings);
        });

        View::composer('dashboard', function ($view) {
            $settings = Setting::findOrFail(1);

            // Pass the retrieved values to the navigation Blade view
            $view->with('setting', $settings);
        });

    }
}
