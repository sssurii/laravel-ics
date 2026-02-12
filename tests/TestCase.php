<?php

namespace INSAN\ICS\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getDefaultConfig(): array
    {
        return [
            'DAY_LIGHT_SAVING' => false,
            'DAY_LIGHT_SAVING_START_MONTH' => '03',
            'DAY_LIGHT_SAVING_END_MONTH' => '10',
            'DAY_LIGHT_SAVING_OFFSET' => '1 hours',
        ];
    }
}
