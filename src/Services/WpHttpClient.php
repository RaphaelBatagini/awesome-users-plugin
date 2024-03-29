<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Services;

use RaphaelBatagini\AwesomeUsersPlugin\Exceptions\HttpException;
use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IHttpClient;
use RaphaelBatagini\AwesomeUsersPlugin\Exceptions\JsonDecodeException;
use WP_Http;

class WpHttpClient implements IHttpClient
{
    /**
     * An WP_Http to be wrapped
     * @var WP_Http
     */
    private WP_Http $httpTool;

    /**
     * Wrap an WP_Http class for better control over its returns
     *
     * @param WP_Http $wpHttp to make the http requests
     *
     * @return self
     */
    public function __construct(WP_Http $wpHttp)
    {
        $this->httpTool = $wpHttp;
    }

    /**
     * Handle get requests
     *
     * @param string $url
     *
     * @return array
     * @throws HttpException if request fail
     */
    public function get(string $url): array
    {
        $response = $this->httpTool->get($url);

        if (!empty($response->errors)) {
            throw new HttpException($response->errors['http_request_failed'][0]);
        }

        $decodedBody = json_decode($response['body'], true);
        $jsonLastError = json_last_error();

        if ($jsonLastError) {
            throw new JsonDecodeException($jsonLastError);
        }

        return $decodedBody;
    }
}
