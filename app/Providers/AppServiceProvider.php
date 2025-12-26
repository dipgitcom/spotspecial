<?php

namespace App\Providers;

use App\Models\AdminSetting;
use App\Models\System;
use Illuminate\Support\Facades\View;
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
        // Get Data From Database
        View::composer('*', function ($view) {
            $admin_setting = AdminSetting::first();
            $view->with('admin_setting', $admin_setting);
        });
    }
}
