<?php

namespace RaphaelBatagini\AwesomeUsersPlugin\Contracts;

interface IUserService
{
    public function list(): array;
    public function detail(int $userId): object;
}
