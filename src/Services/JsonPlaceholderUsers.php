<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Services;

use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IUserService;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\User;
use RaphaelBatagini\AwesomeUsersPlugin\Collections\Users as UsersCollection;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\Address;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\Company;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\Geolocalization;

class JsonPlaceholderUsers implements IUserService
{
    private $sourceUrl;

    public function __construct()
    {
        $this->sourceUrl = 'https://jsonplaceholder.typicode.com/users';
    }

    public function list(): UsersCollection
    {
        $apiUsers = $this->retrieveUsersListFromSource();

        $users = array_map(function (object $apiUser): User {
            return $this->generateUserDto($apiUser);
        }, $apiUsers);

        return new UsersCollection($users);
    }

    public function detail(int $userId): User
    {
        $apiUser = $this->retrieveUserDetailsFromSource($userId);

        return $this->generateUserDto($apiUser);
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

    private function generateUserDto(object $user): User
    {
        $geo = new Geolocalization(
            $user->address->geo->lat,
            $user->address->geo->lng
        );

        $address = new Address(
            $user->address->street,
            $user->address->suite,
            $user->address->city,
            $user->address->zipcode,
            $geo
        );

        $company = new Company(
            $user->company->name,
            $user->company->catchPhrase
        );

        return new User(
            $user->id,
            $user->name,
            $user->username,
            $user->email,
            $address,
            $user->phone,
            $user->website,
            $company
        );
    }
}
