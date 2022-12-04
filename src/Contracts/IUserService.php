<?php

namespace RaphaelBatagini\AwesomeUsersPlugin\Contracts;

use RaphaelBatagini\AwesomeUsersPlugin\DTOs\User;
use RaphaelBatagini\AwesomeUsersPlugin\Collections\Users;

interface IUserService
{
    /**
     * Ensure all User Services can list users and generate a Users collection
     *
     * @return Users
     */
    public function list(): Users;

    /**
     * Ensure all User Services can details its users and generate a User DTO
     *
     * @return User
     */
    public function detail(int $userId): User;
}
