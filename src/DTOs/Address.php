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

    /**
     * Sets up object properties
     *
     * @param string $street
     * @param string $suite
     * @param string $city
     * @param string $zipcode
     * @param Geolocalization $geo
     *
     * @return self
     */
    public function __construct(string $street, string $suite, string $city, string $zipcode, Geolocalization $geo)
    {
        $this->changeStreet($street)
            ->changeSuite($suite)
            ->changeCity($city)
            ->changeZipcode($zipcode)
            ->changeGeo($geo);
    }

    /**
     * Convert object properties to array
     *
     * @return array
     */
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
     *
     * @return string
     */
    public function street(): string
    {
        return $this->street;
    }

    /**
     * Change the value of street
     *
     * @return self
     */
    public function changeStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get the value of suite
     *
     * @return string
     */
    public function suite(): string
    {
        return $this->suite;
    }

    /**
     * Set the value of suite
     *
     * @return self
     */
    public function changeSuite(string $suite): self
    {
        $this->suite = $suite;

        return $this;
    }

    /**
     * Get the value of city
     *
     * @return string
     */
    public function city(): string
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return self
     */
    public function changeCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of zipcode
     *
     * @return string
     */
    public function zipcode(): string
    {
        return $this->zipcode;
    }

    /**
     * Set the value of zipcode
     *
     * @return self
     */
    public function changeZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get the value of geo
     *
     * @return Geolocalization
     */
    public function geo(): Geolocalization
    {
        return $this->geo;
    }

    /**
     * Set the value of geo
     *
     * @return self
     */
    public function changeGeo(Geolocalization $geo): self
    {
        $this->geo = $geo;

        return $this;
    }
}
