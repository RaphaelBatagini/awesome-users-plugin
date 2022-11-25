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

    public function list(): array
    {
        return $this->retrieveUsersListFromSource();
    }

    public function detail(int $userId): object
    {
        return $this->retrieveUserDetailsFromSource(1);
    }

    private function retrieveUsersListFromSource(): array
    {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_URL, $this->sourceUrl);
        $result = curl_exec($curlHandle);
        curl_close($curlHandle);

        return json_decode($result);
    }

    private function retrieveUserDetailsFromSource(int $id): object
    {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_URL, "{$this->sourceUrl}/{$id}");
        $result = curl_exec($curlHandle);
        curl_close($curlHandle);

        return json_decode($result);
    }
}
