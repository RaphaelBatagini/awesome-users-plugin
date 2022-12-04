<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Tests\APIs;

use Mockery;
use RaphaelBatagini\AwesomeUsersPlugin\Tests\AwesomeUsersTestCase;
use RaphaelBatagini\AwesomeUsersPlugin\APIs\Users;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\Address;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\Company;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\Geolocalization;
use RaphaelBatagini\AwesomeUsersPlugin\DTOs\User;
use RaphaelBatagini\AwesomeUsersPlugin\Services\JsonPlaceholderUsers;
use RaphaelBatagini\AwesomeUsersPlugin\Services\WpHttpClient;
use WP_Mock;

class UsersTest extends AwesomeUsersTestCase
{
    public function testRegisterEndpoints()
    {
        $serviceMock = Mockery::mock(JsonPlaceholderUsers::class)->makePartial();
        $sut = new Users($serviceMock);
        
        WP_Mock::expectActionAdded('rest_api_init', [$sut, 'registerListEndpoint'], 10, 1);
        WP_Mock::expectActionAdded('rest_api_init', [$sut, 'registerDetailsEndpoint'], 10, 1);
        
        $sut->registerEndpoints();
    }

    public function testRegisterListEndpoint()
    {
        $serviceMock = Mockery::mock(JsonPlaceholderUsers::class)->makePartial();
        $sut = new Users($serviceMock);

        WP_Mock::userFunction('register_rest_route', [
            'times' => 1,
            'args' => [
                'awesome-users/v1',
                '/list',
                [
                    'methods' => 'GET',
                    'callback' => [$sut, 'handleList'],
                ],
            ],
            'return' => true,
        ]);

        $sut->registerListEndpoint();
    }

    public function testRegisterDetailsEndpoint()
    {
        $serviceMock = Mockery::mock(JsonPlaceholderUsers::class)->makePartial();
        $sut = new Users($serviceMock);

        WP_Mock::userFunction('register_rest_route', [
            'times' => 1,
            'args' => [
                'awesome-users/v1',
                '/details/(?P<id>\d+)',
                [
                    'methods' => 'GET',
                    'callback' => [$sut, 'handleDetails'],
                ],
            ],
            'return' => true,
        ]);

        $sut->registerDetailsEndpoint();
    }

    /**
     * @dataProvider userProvider
     */
    public function testHandleList($user)
    {
        $httpClientMock = Mockery::mock(WpHttpClient::class)
            ->shouldReceive('get')
            ->andReturn([ $user ])
            ->getMock();

        $service = new JsonPlaceholderUsers($httpClientMock);
        $sut = new Users($service);
        
        $result = $sut->handleList();
        
        $this->assertEquals([$user], $result);
    }

    /**
     * @dataProvider userProvider
     */
    public function testHandleDetails($user)
    {
        $httpClientMock = Mockery::mock(WpHttpClient::class)
            ->shouldReceive('get')
            ->andReturn($user)
            ->getMock();

        $service = new JsonPlaceholderUsers($httpClientMock);
        $sut = new Users($service);

        $requestMock = $this->getMockBuilder('ArrayAccess')
            ->setMockClassName('WP_REST_Request')
            ->getMock();
        
        $result = $sut->handleDetails($requestMock);
        
        $this->assertEquals($user, $result);
    }

    public function userProvider(): array
    {
        $geo = new Geolocalization('51.003290', '7.117580');
        $address = new Address('Some Street 123', '', 'Some city', '01234567', $geo);
        $company = new Company('Some name', 'Some Catch Phrase');
        $user = new User(
            1,
            'Some name',
            'someusername',
            'some@email.com',
            $address,
            '11954924915',
            'somewebsite.com',
            $company
        );

        return [
            [$user->toArray()],
        ];
    }
}
