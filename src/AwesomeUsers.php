<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin;

use RaphaelBatagini\AwesomeUsersPlugin\APIs\Users;
use RaphaelBatagini\AwesomeUsersPlugin\Services\JsonPlaceholderUsers;

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
        $usersService = new JsonPlaceholderUsers();
        $usersApi = new Users($usersService);
        $usersApi->registerEndpoints();
    }
}
