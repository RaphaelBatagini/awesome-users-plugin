<?php

# -*- coding: utf-8 -*-

$vendor = dirname(dirname(__FILE__)) . '/vendor/';

if (! realpath($vendor)) {
    die('Please install via Composer before running tests.');
}

if (! defined('PHPUNIT_COMPOSER_INSTALL')) {
    define('PHPUNIT_COMPOSER_INSTALL', $vendor . 'autoload.php');
}

require_once $vendor . 'autoload.php';

WP_Mock::bootstrap();

unset($vendor);