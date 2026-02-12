<?php

namespace INSAN\ICS\Tests\Feature;

use INSAN\ICS\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_config_is_merged(): void
    {
        $this->assertFalse(config('ics.DAY_LIGHT_SAVING'));
        $this->assertEquals('03', config('ics.DAY_LIGHT_SAVING_START_MONTH'));
        $this->assertEquals('10', config('ics.DAY_LIGHT_SAVING_END_MONTH'));
        $this->assertEquals('1 hours', config('ics.DAY_LIGHT_SAVING_OFFSET'));
    }

    public function test_config_can_be_overridden(): void
    {
        config(['ics.DAY_LIGHT_SAVING' => true]);
        
        $this->assertTrue(config('ics.DAY_LIGHT_SAVING'));
    }
}
