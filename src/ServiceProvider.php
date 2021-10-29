<?php

namespace FullStackAppCo\Windicator;

use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'windicator');
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/windicator'),
        ], 'windicator-assets');
    }
}