<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Tests\Utilities;

use RaphaelBatagini\AwesomeUsersPlugin\Tests\AwesomeUsersCacheTestCase;
use RaphaelBatagini\AwesomeUsersPlugin\Utilities\CacheTool;
use WP_Mock;

class CacheToolTest extends AwesomeUsersCacheTestCase
{
    public function testExecute(): void
    {
        $cacheKey = self::$faker->slug();
        $cacheContent = self::$faker->text();

        WP_Mock::userFunction('wp_cache_get', [
            'times' => '1',
            'return' => false,
        ]);

        WP_Mock::userFunction('wp_cache_add', [
            'times' => '1',
            'return' => true,
        ]);

        WP_Mock::userFunction('wp_cache_get', [
            'times' => '1',
            'return' => true,
        ]);

        $result = CacheTool::execute($cacheKey, static function () use ($cacheContent): string {
            return $cacheContent;
        }, 10);

        $this->assertEquals($cacheContent, $result);

        $cachedResult = CacheTool::execute($cacheKey, static function () use ($cacheContent): string {
            return $cacheContent;
        }, 10);

        $this->assertEquals($cacheContent, $cachedResult);
    }
}
