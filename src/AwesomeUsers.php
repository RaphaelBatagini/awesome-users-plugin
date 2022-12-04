<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin;

use RaphaelBatagini\AwesomeUsersPlugin\APIs\Users;
use RaphaelBatagini\AwesomeUsersPlugin\Services\JsonPlaceholderUsers;
use RaphaelBatagini\AwesomeUsersPlugin\Services\VirtualPage;
use RaphaelBatagini\AwesomeUsersPlugin\Services\WpHttpClient;

final class AwesomeUsers
{
    private const AWESOME_USERS_PAGE_SLUG = 'my-awesome-users';
    private const AWESOME_USERS_PAGE_TITLE = 'Awesome Users';
    private static $instance;

    private function __construct()
    {
    }

    public static function instance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function init()
    {
        $this->initUsersApi();
        $this->createUsersPage();
    }

    private function initUsersApi(): void
    {
        $usersService = new JsonPlaceholderUsers(new WpHttpClient(new \WP_Http()));
        $usersApi = new Users($usersService);
        $usersApi->registerEndpoints();
    }

    private function createUsersPage(): void
    {
        add_action('wp_enqueue_scripts', static function () {
            $scriptPath = dirname(__FILE__, 2) . '/dist/main.js';
            $scriptAssetPath = dirname(__FILE__, 2) . '/dist/main.asset.php';
            $scriptAsset = file_exists($scriptAssetPath)
                ? require($scriptAssetPath)
                : ['dependencies' => [], 'version' => filemtime($scriptPath)];
            $scriptUrl = plugins_url('dist/main.js', dirname(__FILE__));

            wp_enqueue_script(
                'awesome_users_page_script',
                $scriptUrl,
                $scriptAsset['dependencies'],
                $scriptAsset['version'],
                true,
            );
        });

        $virtualPage = new VirtualPage(
            self::AWESOME_USERS_PAGE_SLUG,
            self::AWESOME_USERS_PAGE_TITLE,
            __DIR__ . '/../templates/users-list.php',
        );
        $virtualPage->init();
    }
}
