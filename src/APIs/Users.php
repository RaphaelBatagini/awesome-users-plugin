<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\APIs;

use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IApi;
use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IUserService;
use WP_REST_Request;

final class Users implements IApi
{
    private $service;

    public function __construct(IUserService $service)
    {
        $this->service = $service;
    }

    public function handleList(): array
    {
        return $this->service
            ->list()
            ->toArray();
    }

    public function handleDetails(WP_REST_Request $request): array
    {
        return $this->service
            ->detail(intval($request['id']))
            ->toArray();
    }

    public function registerEndpoints(): void
    {
        add_action('rest_api_init', function () {
            register_rest_route('awesome-users/v1', '/list', [
                'methods' => 'GET',
                'callback' => [ $this, 'handleList' ],
            ]);

            register_rest_route('awesome-users/v1', '/details/(?P<id>\d+)', [
                'methods' => 'GET',
                'callback' => [ $this, 'handleDetails' ],
            ]);
        });
    }
}
