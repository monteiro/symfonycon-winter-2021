<?php

namespace App\RentCar\Application\Customer;

class CreateCustomerCommand
{
    private string $name;
    private string $address;
    private string $phone;
    private string $email;
    private string $actorId;

    public function __construct(string $name, string $address, string $phone, string $email, string $actorId)
    {
        $this->name    = $name;
        $this->address = $address;
        $this->phone   = $phone;
        $this->email   = $email;
        $this->actorId = $actorId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getActorId(): string
    {
        return $this->actorId;
    }

}