<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\DTOs;

final class Geolocalization
{
    private string $lat;
    private string $lng;

    /**
     * Sets up object properties
     *
     * @param string $lat
     * @param string $lng
     *
     * @return self
     */
    public function __construct(string $lat, string $lng)
    {
        $this->changeLat($lat)
            ->changeLng($lng);
    }

    /**
     * Convert object properties to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'lat' => $this->lat(),
            'lng' => $this->lng(),
        ];
    }

    /**
     * Get the value of lat
     *
     * @return string
     */
    public function lat(): string
    {
        return $this->lat;
    }

    /**
     * Set the value of lat
     *
     * @return self
     */
    public function changeLat(string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get the value of lng
     *
     * @return string
     */
    public function lng(): string
    {
        return $this->lng;
    }

    /**
     * Set the value of lng
     *
     * @return self
     */
    public function changeLng(string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }
}
