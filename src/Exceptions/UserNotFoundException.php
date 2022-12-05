<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Exceptions;

class UserNotFoundException extends \Exception
{
    /**
     * Throws when user is requested but not found
     *
     * @param int $userId
     *
     * @return self
     */
    public function __construct(int $userId)
    {
        parent::__construct("Failed to find user with ID: $userId");
    }
}
