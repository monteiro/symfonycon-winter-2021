<?php

namespace App\Tests\RentCar\Infrastructure\Persistence\InMemory;

use App\RentCar\Domain\Model\Customer\Customer;
use App\RentCar\Domain\Model\Customer\CustomerNotFoundException;
use App\RentCar\Domain\Model\Customer\CustomerRepository;

final class InMemoryCustomerRepository implements CustomerRepository
{
    /**
     * @var array<Customer>
     */
    private array $customers = [];
    private ?string $uuid;

    public function __construct(?string $uuid = null)
    {
        $this->uuid = $uuid;
    }

    public function save(Customer $customer): void
    {
        $this->customers[$customer->getId()] = $customer;
    }

    public function nextIdentity(): string
    {
        if ($this->uuid) {
            return $this->uuid;
        }

        return 'ee5e93a7-6880-4fcb-9de1-59e575d691f5';
    }

    public function getCustomers(): array
    {
        return $this->customers;
    }

    public function findById(string $customerId): Customer
    {
        if (isset($this->customers[$customerId])) {
            return $this->customers[$customerId];
        }

        throw CustomerNotFoundException::withId($customerId);
    }
}
