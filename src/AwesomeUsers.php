<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin;

final class AwesomeUsers
{
    private function __construct()
    {
    }

    public static function instance(): self
    {
        static $instance;
        if ($instance) {
            return $instance;
        }

        return new self();
    }

    public function init()
    {
        // TODO: add plugin start up requirements
    }
}
