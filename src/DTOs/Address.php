<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\DTOs;

use RaphaelBatagini\AwesomeUsersPlugin\Contracts\IDto;

final class Address implements IDto
{
    private string $street;
    private string $suite;
    private string $city;
    private string $zipcode;
    private Geolocalization $geo;

    public function __construct(string $street, string $suite, string $city, string $zipcode, Geolocalization $geo)
    {
        $this->changeStreet($street)
            ->changeSuite($suite)
            ->changeCity($city)
            ->changeZipcode($zipcode)
            ->changeGeo($geo);
    }

    public function toArray(): array
    {
        return [
            'street' => $this->street(),
            'suite' => $this->suite(),
            'city' => $this->city(),
            'zipcode' => $this->zipcode(),
            'geo' => $this->geo()->toArray(),
        ];
    }

    /**
     * Get the value of street
     */
    public function street(): string
    {
        return $this->street;
    }

    /**
     * Set the value of street
     */
    public function changeStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get the value of suite
     */
    public function suite(): string
    {
        return $this->suite;
    }

    /**
     * Set the value of suite
     */
    public function changeSuite(string $suite): self
    {
        $this->suite = $suite;

        return $this;
    }

    /**
     * Get the value of city
     */
    public function city(): string
    {
        return $this->city;
    }

    /**
     * Set the value of city
     */
    public function changeCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of zipcode
     */
    public function zipcode(): string
    {
        return $this->zipcode;
    }

    /**
     * Set the value of zipcode
     */
    public function changeZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get the value of geo
     */
    public function geo(): Geolocalization
    {
        return $this->geo;
    }

    /**
     * Set the value of geo
     */
    public function changeGeo(Geolocalization $geo): self
    {
        $this->geo = $geo;

        return $this;
    }
}
