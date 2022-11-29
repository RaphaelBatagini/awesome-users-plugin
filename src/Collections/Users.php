<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Collections;

use RaphaelBatagini\AwesomeUsersPlugin\DTOs\User;

class Users extends Collection
{
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    public function toArray(): array
    {
        $iterator = parent::getIterator();

        return array_map(static function (User $item): array {
            return $item->toArray();
        }, iterator_to_array($iterator));
    }
}
