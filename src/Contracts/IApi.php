<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Contracts;

interface IApi {
    public function registerEndpoints(): void;
}