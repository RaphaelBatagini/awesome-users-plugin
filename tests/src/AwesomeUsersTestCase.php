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
        self::bypassCache();
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

    private static function bypassCache(): void
    {
        WP_Mock::userFunction('wp_cache_get', [
            'times' => '0+',
            'return' => false,
        ]);

        WP_Mock::userFunction('wp_cache_add', [
            'times' => '0+',
            'return' => true,
        ]);
    }
}
