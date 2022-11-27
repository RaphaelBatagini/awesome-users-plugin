<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\DTOs;

final class User
{
    private int $id;
    private string $name;
    private string $username;
    private string $email;
    private Address $address;
    private string $phone;
    private string $website;
    private Company $company;

    public function __construct(
        int $id,
        string $name,
        string $username,
        string $email,
        Address $address,
        string $phone,
        string $website,
        Company $company
    ) {

        $this->changeId($id)
            ->changeName($name)
            ->changeUsername($username)
            ->changeEmail($email)
            ->changeAddress($address)
            ->changePhone($phone)
            ->changeWebsite($website)
            ->changeCompany($company);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'username' => $this->username(),
            'email' => $this->email(),
            'address' => $this->address()->toArray(),
            'phone' => $this->phone(),
            'website' => $this->website(),
            'company' => $this->company()->toArray(),
        ];
    }

    /**
     * Get the value of id
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function changeId(int $id): self
    {
        $this->id = $id;

        return $this;
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
     * Get the value of username
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     */
    public function changeUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function changeEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of address
     */
    public function address(): Address
    {
        return $this->address;
    }

    /**
     * Set the value of address
     */
    public function changeAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of phone
     */
    public function phone(): string
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     */
    public function changePhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of website
     */
    public function website(): string
    {
        return $this->website;
    }

    /**
     * Set the value of website
     */
    public function changeWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get the value of company
     */
    public function company(): Company
    {
        return $this->company;
    }

    /**
     * Set the value of company
     */
    public function changeCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
