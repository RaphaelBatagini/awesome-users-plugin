<?php

// -*- coding: utf-8 -*-
// phpcs:disable Inpsyde.CodeQuality.NoAccessors.NoSetter

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Tests;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use WP_Mock;

class AwesomeUsersTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected static $faker;

    protected function setUp(): void
    {
        parent::setUp();
        WP_Mock::setUp();
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
        parent::tearDown();
    }

    public static function setUpBeforeClass(): void
    {
        self::$faker = Factory::create();
    }
}
