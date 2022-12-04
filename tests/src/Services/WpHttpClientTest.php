<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Tests\Services;

use PHPUnit\Framework\TestCase;
use RaphaelBatagini\AwesomeUsersPlugin\Exceptions\HttpException;
use RaphaelBatagini\AwesomeUsersPlugin\Exceptions\JsonDecodeException;
use RaphaelBatagini\AwesomeUsersPlugin\Services\WpHttpClient;

class WpHttpClientTest extends TestCase
{
    public function testGetReturnsAnArrayWhenExternalUrlReturnsAJson(): void
    {
        $mock = \Mockery::mock('WP_Http');
        $mock->shouldReceive('get')
            ->times(1)
            ->andReturn([
                'body' => '{ "property": "value" }',
            ]);

        $client = new WpHttpClient($mock);
        $response = $client->get('https://someurl.com');

        $this->assertEquals([
            'property' => 'value',
        ], $response);
    }

    public function testGetThrowsAHttpExceptionWhenRequestFail(): void
    {
        $this->expectException(HttpException::class);

        $response = new \stdClass();
        $response->errors = ['http_request_failed' => ['Some unknown http error']];

        $mock = \Mockery::mock('WP_Http');
        $mock->shouldReceive('get')
            ->times(1)
            ->andReturn($response);

        $client = new WpHttpClient($mock);
        $client->get('https://someurl.com');
    }

    public function testGetThrowsAJsonDecodeExceptionWhenRequestReturnsAnInvalidJson(): void
    {
        $this->expectException(JsonDecodeException::class);

        $mock = \Mockery::mock('WP_Http');
        $mock->shouldReceive('get')
            ->times(1)
            ->andReturn([
                'body' => '{ property: "value" }',
            ]);

        $client = new WpHttpClient($mock);
        $client->get('https://someurl.com');
    }
}
