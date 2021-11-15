<?php

namespace App\RentCar\Domain\Model\Customer;

interface CustomerRepository
{
    public function save(Customer $customer): void;
    public function findById(string $customerId): Customer;
    public function nextIdentity(): string;
}
