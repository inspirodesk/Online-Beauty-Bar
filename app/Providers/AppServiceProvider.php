<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

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

        // Define default settings
        $defaultSettings = [
            'company_name' => 'Extreme Coders',
            'email' => 'info@extremecoders.us',
            'mobile' => '0772353119',
            'logo' => 'logo',
            'favicon' => 'favicon',
            'login_img' => 'login_path',
            'profile' => 'profile',
            'desc' => 'Software Development Company',
            'tags' => 'Jaffna,Software Company, Custom Laravel App',
            'solution' => 'Extreme Coders 🚀'
        ];

        // Check if the settings table exists and retrieve settings if it does
        if (Schema::hasTable('settings')) {
            $settings = Setting::find(1) ?? (object) $defaultSettings; // Use default settings if not found
        } else {
            $settings = (object) $defaultSettings; // Convert array to object for consistency
        }

        View::composer(['layouts.nav', 'layouts.app', 'layouts.auth', 'dashboard'], function ($view) use ($settings) {
            $view->with('setting', $settings);
        });

    }
}
