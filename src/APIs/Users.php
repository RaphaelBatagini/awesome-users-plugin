<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\APIs;

use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IApi;
use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IUserService;
use WP_REST_Request;

final class Users implements IApi
{
    /**
     * Service to be used to access users data
     * @var IUserService
     */
    private IUserService $service;

    /**
     * Sets up object service
     *
     * @return self
     */
    public function __construct(IUserService $service)
    {
        $this->service = $service;
    }

    /**
     * Handler for the users list request
     *
     * @return array
     */
    public function handleList(): array
    {
        try {
            return $this->service
                ->list()
                ->toArray();
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * Handler for the users details request
     *
     * @return array
     */
    public function handleDetails(WP_REST_Request $request): array
    {
        try {
            return $this->service
                ->detail(intval($request['id']))
                ->toArray();
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * Register users endpoints in the WordPress API
     *
     * @return void
     */
    public function registerEndpoints(): void
    {
        add_action('rest_api_init', [$this, 'registerListEndpoint']);
        add_action('rest_api_init', [$this, 'registerDetailsEndpoint']);
    }

    /**
     * Register users list endpoint in the WordPress API
     *
     * @return void
     */
    public function registerListEndpoint(): void
    {
        register_rest_route('awesome-users/v1', '/list', [
            'methods' => 'GET',
            'callback' => [ $this, 'handleList' ],
        ]);
    }

    /**
     * Register users details endpoint in the WordPress API
     *
     * @return void
     */
    public function registerDetailsEndpoint(): void
    {
        register_rest_route('awesome-users/v1', '/details/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [ $this, 'handleDetails' ],
        ]);
    }
}
