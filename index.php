<?php

/**
 * Plugin Name: Awesome Users Plugin
 * Plugin URI: https://github.com/RaphaelBatagini/awesome-users-plugin
 * Description: Users listing plugin.
 * Author: Raphael Batagini
 * Author URI: https://github.com/RaphaelBatagini
 * Version: 1.0.0
 * License: GPLv2 or later
 * Text Domain: awesome-users
 * Domain Path: /languages/
 */

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin;

defined('ABSPATH') || exit;

require_once(__DIR__ . '/vendor/autoload.php');

$core = AwesomeUsers::instance();
$core->init();
