<?php

// -*- coding: utf-8 -*-
// phpcs:disable Inpsyde.CodeQuality.NoAccessors.NoSetter

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Tests;

use WP_Mock;

class AwesomeUsersCacheTestCase extends AwesomeUsersTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WP_Mock::setUp();
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
        parent::tearDown();
    }
}
