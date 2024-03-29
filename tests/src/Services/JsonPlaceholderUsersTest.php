<?php

// -*- coding: utf-8 -*-
// phpcs:disable Inpsyde.CodeQuality.NoAccessors.NoSetter

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Tests\Services;

use RaphaelBatagini\AwesomeUsersPlugin\Services\JsonPlaceholderUsers;
use RaphaelBatagini\AwesomeUsersPlugin\Collections\Users;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\User;
use RaphaelBatagini\AwesomeUsersPlugin\Exceptions\UserNotFoundException;
use RaphaelBatagini\AwesomeUsersPlugin\Services\WpHttpClient;
use RaphaelBatagini\AwesomeUsersPlugin\Tests\AwesomeUsersTestCase;
use WP_Mock;

class JsonPlaceholderUsersTest extends AwesomeUsersTestCase
{
    private static $userDataFromHttpClient;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$userDataFromHttpClient = [
            "id" => 1,
            "name" => "Leanne Graham",
            "username" => "Bret",
            "email" => "Sincere@april.biz",
            "address" => [
                "street" => "Kulas Light",
                "suite" => "Apt. 556",
                "city" => "Gwenborough",
                "zipcode" => "92998-3874",
                "geo" => [
                    "lat" => "-37.3159",
                    "lng" => "81.1496",
                ],
            ],
            "phone" => "1-770-736-8031 x56442",
            "website" => "hildegard.org",
            "company" => [
                "name" => "Romaguera-Crona",
                "catchPhrase" => "Multi-layered client-server neural-net",
            ],
        ];
    }

    public function testListReturnsAnUsersCollection(): void
    {
        $stub = $this->createStub(WpHttpClient::class);
        $stub->method('get')
            ->willReturn([self::$userDataFromHttpClient]);

        $usersService = new JsonPlaceholderUsers($stub);
        $usersList = $usersService->list();

        $this->assertInstanceOf(Users::class, $usersList);
        $this->assertEquals(1, $usersList->count());
    }

    public function testListLetExceptionBubbleUpWhenHttpClientFail(): void
    {
        $exception = new \Exception();
        $this->expectException(get_class($exception));

        $stub = $this->createStub(WpHttpClient::class);
        $stub->method('get')
            ->willThrowException($exception);

        $usersService = new JsonPlaceholderUsers($stub);
        $usersService->list();
    }

    public function testDetailReturnsAnUserDto(): void
    {
        $stub = $this->createStub(WpHttpClient::class);
        $stub->method('get')
            ->willReturn(self::$userDataFromHttpClient);

        $usersService = new JsonPlaceholderUsers($stub);
        $userDetail = $usersService->detail(1);
        $this->assertInstanceOf(User::class, $userDetail);
    }

    public function testDetailLetExceptionBubbleUpWhenHttpClientFail(): void
    {
        $exception = new \Exception();
        $this->expectException(get_class($exception));

        $stub = $this->createStub(WpHttpClient::class);
        $stub->method('get')
            ->willThrowException($exception);

        $usersService = new JsonPlaceholderUsers($stub);
        $usersService->detail(1);
    }

    public function testDetailThrowsUserNotFoundException(): void
    {
        $stub = $this->createStub(WpHttpClient::class);
        $stub->method('get')
            ->willReturn([]);

        $this->expectException(UserNotFoundException::class);

        $usersService = new JsonPlaceholderUsers($stub);
        $usersService->detail(self::$faker->randomNumber(5));
    }
}
