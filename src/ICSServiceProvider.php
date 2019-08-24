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
    public function register()
    {
        $this->app->make('INSAN\ICS\ICS');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
