<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Contracts;

interface IApi
{
    /**
     * Ensure all API classes register its endpoints
     *
     * @return void
     */
    public function registerEndpoints(): void;
}
