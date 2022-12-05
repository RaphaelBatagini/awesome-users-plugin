<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Services;

use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IUserService;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\User;
use RaphaelBatagini\AwesomeUsersPlugin\Collections\Users as UsersCollection;
use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IHttpClient;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\Address;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\Company;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\Geolocalization;
use RaphaelBatagini\AwesomeUsersPlugin\Utilities\CacheTool;

class JsonPlaceholderUsers implements IUserService
{
    /**
     * Http Client to make requests to the jsonplaceholder.typicode.com API
     * @var IHttpClient
     */
    private IHttpClient $httpClient;

    /**
     * jsonplaceholder.typicode.com api address
     * @var string
     */
    private string $sourceUrl;

    private const AWESOME_USERS_JP_LIST_CACHE_KEY = 'awesome_users_jp_list_all';
    private const AWESOME_USERS_JP_DETAILS_CACHE_KEY = 'awesome_users_jp_details';

    /**
     * @param IHttpClient $httpClient client responsible for the http requests
     *
     * @return self
     */
    public function __construct(IHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->sourceUrl = 'https://jsonplaceholder.typicode.com/users';
    }

    /**
     * Retrieve Users List from JsonPlaceholder API
     *
     * @return UsersCollection
     * @throws \Exception
     */
    public function list(): UsersCollection
    {
        $apiUsers = CacheTool::execute(
            self::AWESOME_USERS_JP_LIST_CACHE_KEY,
            function (): array {
                return $this->httpClient->get($this->sourceUrl);
            }
        );

        $users = array_map(function (array $apiUser): User {
            return $this->generateUserDto($apiUser);
        }, $apiUsers);

        return new UsersCollection($users);
    }

    /**
     * Retrieve User Details from JsonPlaceholder API
     *
     * @return User
     * @throws \Exception
     */
    public function detail(int $userId): User
    {
        $apiUser = CacheTool::execute(
            self::AWESOME_USERS_JP_DETAILS_CACHE_KEY,
            function () use ($userId): array {
                return $this->httpClient->get("{$this->sourceUrl}/{$userId}");
            }
        );
        return $this->generateUserDto($apiUser);
    }

    /**
     * Convert an user array into an user DTO
     *
     * @param array $user
     *
     * @return User
     * @throws \Exception
     */
    private function generateUserDto(array $user): User
    {
        $geo = new Geolocalization(
            $user['address']['geo']['lat'],
            $user['address']['geo']['lng'],
        );

        $address = new Address(
            $user['address']['street'],
            $user['address']['suite'],
            $user['address']['city'],
            $user['address']['zipcode'],
            $geo
        );

        $company = new Company(
            $user['company']['name'],
            $user['company']['catchPhrase'],
        );

        return new User(
            $user['id'],
            $user['name'],
            $user['username'],
            $user['email'],
            $address,
            $user['phone'],
            $user['website'],
            $company
        );
    }
}
