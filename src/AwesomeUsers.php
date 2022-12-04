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
    /**
     * The slug to be used in the page to list users
     */
    private const AWESOME_USERS_PAGE_SLUG = 'my-awesome-users';

    /**
     * The title to be used in the page to list users
     */
    private const AWESOME_USERS_PAGE_TITLE = 'Awesome Users';

    /**
     * Hold the singleton instance
     */
    private static self $instance;

    /**
     * Private constructor to limit instance access
     *
     * @return self
     */
    private function __construct()
    {
    }

    /**
     * Retrieves the class instance
     *
     * @return self
     */
    public static function instance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Initialize the entire plugin processes
     *
     * @return void
     */
    public function init(): void
    {
        $this->initUsersApi();
        $this->createUsersPage();
    }

    /**
     * Initialize users API defining a user service and registering its endpoints
     *
     * @return void
     */
    private function initUsersApi(): void
    {
        $usersService = new JsonPlaceholderUsers(
            new WpHttpClient(new \WP_Http())
        );
        $usersApi = new Users($usersService);
        $usersApi->registerEndpoints();
    }

    /**
     * Create the front-end page
     *
     * @return void
     */
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
