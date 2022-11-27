<?php

namespace RaphaelBatagini\AwesomeUsersPlugin\Contracts;

use RaphaelBatagini\AwesomeUsersPlugin\DTOs\User;
use RaphaelBatagini\AwesomeUsersPlugin\Collections\Users as UsersCollection;

interface IUserService
{
    public function list(): UsersCollection;
    public function detail(int $userId): User;
}
