<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Services;

use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IUserService;

class JsonPlaceholderUsers implements IUserService
{
    private $sourceUrl;

    public function __construct()
    {
        $this->sourceUrl = 'https://jsonplaceholder.typicode.com/users';
    }

    public function list(int $page = 1, int $pageLength = 10): array
    {
        return $this->retrieveUsersFromSource();
    }

    public function detail(int $userId): object
    {
        return $this->retrieveUsersFromSource(1);
    }

    private function retrieveUsersFromSource(string | int $path = null): array | object
    {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_URL, "{$this->sourceUrl}/{$path}");
        $result = curl_exec($curlHandle);
        curl_close($curlHandle);

        return json_decode($result);
    }
}
