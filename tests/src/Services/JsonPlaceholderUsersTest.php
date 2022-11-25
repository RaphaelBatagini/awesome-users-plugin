<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Tests\Services;

use PHPUnit\Framework\TestCase;
use RaphaelBatagini\AwesomeUsersPlugin\Services\JsonPlaceholderUsers;

class JsonPlaceholderUsersTest extends TestCase
{
    public function testListReturnsAnArray(): void
    {
        $usersService = new JsonPlaceholderUsers();
        $usersList = $usersService->list();
        $this->assertIsArray($usersList);
    }
}
