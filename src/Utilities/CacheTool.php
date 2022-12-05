<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Utilities;

class CacheTool
{
    /**
     * Uses WP_Object_Cache to cache any action.
     * If the result is already cached, the callback will not be executed.
     * Otherwise, the callback is executed and the result will be stored in memory.
     *
     * @param string $key cache key
     * @param \Closure $callback function to be executed if value is not cached
     * @param int $expiration expiration time in seconds
     *
     * @return mixed
     */
    public static function execute(string $key, \Closure $callback, int $expiration = 0)
    {
        $result = \wp_cache_get($key);

        if ($result === false) {
            $result = $callback();
            \wp_cache_add($key, $result, $expiration);
        }

        return $result;
    }
}
