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
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
        try {
            $activeNotification = \Illuminate\Support\Facades\Cache::remember(
                'active_notification',
                10,
                fn () => \App\Models\Notification::where('is_active', true)->latest()->first()
            );
            \Illuminate\Support\Facades\View::share('activeNotification', $activeNotification);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\View::share('activeNotification', null);
        }
    }
}