<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\DTOs;

final class Company
{
    private string $name;
    private string $catchPhrase;

    public function __construct(string $name, string $catchPhrase)
    {
        $this->changeName($name)
            ->changeCatchPhrase($catchPhrase);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name(),
            'catchPhrase' => $this->catchPhrase(),
        ];
    }

    /**
     * Get the value of name
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function changeName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of catchPhrase
     */
    public function catchPhrase(): string
    {
        return $this->catchPhrase;
    }

    /**
     * Set the value of catchPhrase
     */
    public function changeCatchPhrase(string $catchPhrase): self
    {
        $this->catchPhrase = $catchPhrase;

        return $this;
    }
}
