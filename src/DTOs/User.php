<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\DTOs;

final class User
{
    /**
     * User identification
     * @var int
     */
    private int $id;

    /**
     * Name
     * @var string
     */
    private string $name;

    /**
     * Username/Login
     * @var string
     */
    private string $username;

    /**
     * E-mail
     * @var string
     */
    private string $email;

    /**
     * Adress object
     * @var Address
     */
    private Address $address;

    /**
     * Phone number
     * @var string
     */
    private string $phone;

    /**
     * Website
     * @var string
     */
    private string $website;

    /**
     * Company object
     * @var Company
     */
    private Company $company;

    /**
     * Sets up object properties
     *
     * @param int $id
     * @param string $name
     * @param string $username
     * @param string $email
     * @param Address $address
     * @param string $phone
     * @param string $website
     * @param Company $company
     *
     * @return self
     */
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

    /**
     * Convert object properties to array
     *
     * @return array
     */
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
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return self
     */
    public function changeId(int $id): self
    {
        $this->id = $id;

        return $this;
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
     * Get the value of username
     *
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return self
     */
    public function changeUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return self
     */
    public function changeEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of address
     *
     * @return Address
     */
    public function address(): Address
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return self
     */
    public function changeAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of phone
     *
     * @return string
     */
    public function phone(): string
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return self
     */
    public function changePhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of website
     *
     * @return string
     */
    public function website(): string
    {
        return $this->website;
    }

    /**
     * Set the value of website
     *
     * @return self
     */
    public function changeWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get the value of company
     *
     * @return Company
     */
    public function company(): Company
    {
        return $this->company;
    }

    /**
     * Set the value of company
     *
     * @return self
     */
    public function changeCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
