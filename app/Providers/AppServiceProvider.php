<?php

namespace App\Providers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // if (app()->environment('production')) {
        //     URL::forceScheme('https');
        // }
        try {
            \Illuminate\Support\Facades\View::share(
                'activeNotification',
                \App\Models\Notification::where('is_active', true)->latest()->first()
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\View::share('activeNotification', null);
        }
    }
}