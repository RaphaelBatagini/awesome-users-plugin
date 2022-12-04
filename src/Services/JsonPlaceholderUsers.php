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

class JsonPlaceholderUsers implements IUserService
{
    private $httpClient;
    private $sourceUrl;

    public function __construct(IHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->sourceUrl = 'https://jsonplaceholder.typicode.com/users';
    }

    /**
     * Retrieve Users List from JsonPlaceholder API
     * @return UsersCollection
     * @throws \Exception
     */
    public function list(): UsersCollection
    {
        $apiUsers = $this->httpClient->get($this->sourceUrl);

        $users = array_map(function (array $apiUser): User {
            return $this->generateUserDto($apiUser);
        }, $apiUsers);

        return new UsersCollection($users);
    }

    /**
     * Retrieve User Details from JsonPlaceholder API
     * @return User
     * @throws \Exception
     */
    public function detail(int $userId): User
    {
        $apiUser = $this->httpClient->get("{$this->sourceUrl}/{$userId}");
        return $this->generateUserDto($apiUser);
    }

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
