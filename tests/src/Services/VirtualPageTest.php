<?php

// -*- coding: utf-8 -*-
// phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash
// phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Tests\Services;

use Mockery;
use RaphaelBatagini\AwesomeUsersPlugin\Services\VirtualPage;
use RaphaelBatagini\AwesomeUsersPlugin\Tests\AwesomeUsersTestCase;
use WP_Mock;

class VirtualPageTest extends AwesomeUsersTestCase
{
    public function testInitAddsInitHook(): void
    {
        $sut = new VirtualPage(
            self::$faker->slug(),
            self::$faker->title(),
            self::$faker->filePath()
        );

        WP_Mock::expectActionAdded('init', [$sut, 'registerFilters'], 10, 1);

        $sut->init();
    }

    public function testRegisterFiltersAddsFilterHooks(): void
    {
        $sut = new VirtualPage(
            self::$faker->slug(),
            self::$faker->title(),
            self::$faker->filePath()
        );

        WP_Mock::expectFilterAdded('the_posts', [$sut, 'createPage'], 10, 2);

        $sut->registerFilters();
    }

    public function testCreatePageShouldntProceedWithPageCreationIfSlugIsInvalid(): void
    {
        $pageSlug = self::$faker->slug();

        $sut = new VirtualPage(
            $pageSlug,
            self::$faker->title(),
            self::$faker->filePath()
        );

        WP_Mock::userFunction('get_option', [
            'times' => 1,
            'args' => ['permalink_structure'],
            'return' => true,
        ]);

        $wpQueryMock = Mockery::mock('WP_Query');
        $response = $sut->createPage([], $wpQueryMock);

        $this->assertEmpty($response);
    }

    public function testCreatePageShouldntProceedWithPageCreationIfPostTypeIsNotEmpty(): void
    {
        $pageSlug = self::$faker->slug();

        $oldRequestUri = !empty($_SERVER['REQUEST_URI'])
            ? $_SERVER['REQUEST_URI']
            : '';

        $_SERVER['REQUEST_URI'] = $pageSlug;

        $sut = new VirtualPage(
            $pageSlug,
            self::$faker->title(),
            self::$faker->filePath()
        );

        WP_Mock::userFunction('get_option', [
            'times' => 1,
            'args' => ['permalink_structure'],
            'return' => true,
        ]);

        WP_Mock::userFunction('wp_unslash', [
            'times' => 1,
            'return' => $_SERVER['REQUEST_URI'],
        ]);

        $wpQueryMock = Mockery::mock('WP_Query');
        $wpQueryMock->query = ['post_type' => self::$faker->slug()];
        $response = $sut->createPage([], $wpQueryMock);

        $this->assertEmpty($response);

        $_SERVER['REQUEST_URI'] = $oldRequestUri;
    }

    public function testCreatePageShouldntProceedWithPageCreation(): void
    {
        $oldRequestUri = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $pageSlug = self::$faker->slug();
        $_SERVER['REQUEST_URI'] = '/' . $pageSlug . '/';

        $sut = new VirtualPage(
            $pageSlug,
            self::$faker->title(),
            self::$faker->filePath()
        );

        WP_Mock::userFunction('get_option', [
            'times' => 1,
            'args' => ['permalink_structure'],
            'return' => true,
        ]);

        WP_Mock::userFunction('current_time', [
            'times' => 1,
            'args' => ['mysql'],
            'return' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
        ]);

        WP_Mock::userFunction('current_time', [
            'times' => 1,
            'args' => ['mysql', 1],
            'return' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
        ]);

        WP_Mock::userFunction('get_home_url', [
            'times' => 1,
            'args' => [null, '/' . $pageSlug],
            'return' => self::$faker->url() . '/' . $pageSlug,
        ]);

        WP_Mock::userFunction('wp_unslash', [
            'times' => 1,
            'return' => $_SERVER['REQUEST_URI'],
        ]);

        $wpQueryMock = Mockery::mock('WP_Query')->makePartial();
        Mockery::mock('WP_Post')
            ->shouldReceive('ID')
            ->andReturn(1)
            ->getMock()
            ->makePartial();

        $response = $sut->createPage([], $wpQueryMock);

        $this->assertIsArray($response);
        $this->assertInstanceOf('WP_Post', array_pop($response));

        $_SERVER['REQUEST_URI'] = $oldRequestUri;
    }
}
