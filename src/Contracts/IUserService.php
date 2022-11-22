<?php

namespace RaphaelBatagini\AwesomeUsersPlugin\Contracts;

interface IUserService
{
    public function list(int $page, int $pageLenght): array;
    public function detail(int $userId): object;
}
