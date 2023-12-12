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
        $this->app->make('INSAN\ICS\ICS');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/ics.php' => config_path('ics.php'),
        ]);
    }
}
