<?php

namespace INSAN\ICS;

use Illuminate\Support\ServiceProvider;

class ICSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ics.php',
            'ics'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/ics.php' => config_path('ics.php'),
            ], 'config');
        }
    }
}
