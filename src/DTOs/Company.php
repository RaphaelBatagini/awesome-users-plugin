<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\DTOs;

final class Company
{
    /**
     * Name
     * @var string
     */
    private string $name;

    /**
     * Catch Phrase
     * @var string
     */
    private string $catchPhrase;

    /**
     * Sets up object properties
     *
     * @param string $name
     * @param string $catchPhrase
     *
     * @return self
     */
    public function __construct(string $name, string $catchPhrase)
    {
        $this->changeName($name)
            ->changeCatchPhrase($catchPhrase);
    }

    /**
     * Convert object properties to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name(),
            'catchPhrase' => $this->catchPhrase(),
        ];
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return self
     */
    public function changeName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of catchPhrase
     *
     * @return string
     */
    public function catchPhrase(): string
    {
        return $this->catchPhrase;
    }

    /**
     * Set the value of catchPhrase
     *
     * @return self
     */
    public function changeCatchPhrase(string $catchPhrase): self
    {
        $this->catchPhrase = $catchPhrase;

        return $this;
    }
}
