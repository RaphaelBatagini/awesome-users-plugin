<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Contracts;

interface IHttpClient
{
    /**
     * Ensure all HTTP Clients can make get requests
     *
     * @return array
     */
    public function get(string $url): array;
}
