<?php

namespace App\Providers;

use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesAppServices;

class NativeAppServiceProvider implements ProvidesAppServices
{
    public function boot(): void
    {
        Window::open()
            ->width(1200)
            ->height(800)
            ->url(config('app.url'))
            ->rememberState();
    }
}