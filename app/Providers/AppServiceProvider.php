<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with([
                'footerAbout'   => SiteSetting::get('footer_about'),
                'footerEmail'   => SiteSetting::get('footer_email'),
                'footerPhone'   => SiteSetting::get('footer_phone'),
                'footerAddress' => SiteSetting::get('footer_address'),
            ]);
        });
    }
}
