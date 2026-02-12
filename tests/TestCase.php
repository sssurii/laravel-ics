<?php

namespace INSAN\ICS\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            \INSAN\ICS\ICSServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // Setup default config values
        $app['config']->set('ics.DAY_LIGHT_SAVING', false);
        $app['config']->set('ics.DAY_LIGHT_SAVING_START_MONTH', '03');
        $app['config']->set('ics.DAY_LIGHT_SAVING_END_MONTH', '10');
        $app['config']->set('ics.DAY_LIGHT_SAVING_OFFSET', '1 hours');
    }
}
