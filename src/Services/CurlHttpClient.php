<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Services;

use RaphaelBatagini\AwesomeUsersPlugin\Exceptions\HttpException;
use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IHttpClient;

class CurlHttpClient implements IHttpClient
{
    /**
     * Handle get requests
     * @param string $url
     * @return array
     * @throws HttpException if request fail
     */
    public function get(string $url): array
    {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        $result = curl_exec($curlHandle);
        curl_close($curlHandle);

        return json_decode($result, true);
    }
}