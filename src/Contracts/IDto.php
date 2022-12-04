<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Contracts;

interface IDto
{
    /**
     * Ensure all DTOs convert its properties to array
     *
     * @return array
     */
    public function toArray(): array;
}
