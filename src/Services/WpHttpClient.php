<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Services;

use RaphaelBatagini\AwesomeUsersPlugin\Exceptions\HttpException;
use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IHttpClient;
use WP_Http;

class WpHttpClient implements IHttpClient
{
    private $httpTool;

    public function __construct()
    {
        $this->httpTool = new WP_Http();
    }

    /**
     * Handle get requests
     * @param string $url
     * @return array
     * @throws HttpException if request fail
     */
    public function get(string $url): array
    {
        $response = $this->httpTool->get($url);

        if (!empty($response->errors)) {
            throw new HttpException($response->errors['http_request_failed'][0]);
        }

        return json_decode($response['body'], true);
    }
}