<?php

namespace App\Tests\RentCar\Domain\Customer;

use App\RentCar\Domain\Model\Customer\Customer;
use PHPUnit\Framework\TestCase;

final class CustomerTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateCustomer(): void
    {
        $customerId = '8c760679-fa25-4fc4-9428-965686526c0c';
        $name = 'John Doe';
        $address = 'Rua Paris, 122';
        $phone = '+4419389212211';
        $email = 'joedoe@test.com';
        $actorId = 'b6f927b5-987c-4e5e-9ddd-c61a6b01d27e';

        $customer = Customer::create(
            $customerId,
            $name,
            $address,
            $phone,
            $email,
            $actorId
        );

        $events = $customer->releaseEvents();
        $this->assertCount(1, $events);

        $customerWasCreated = $events[0];
        $this->assertSame($customerWasCreated->getAggregateRootId(), $customerId);
        $this->assertSame($customerWasCreated->getActorId(), $actorId);

        $this->assertSame($customerId, $customer->getId());
        $this->assertSame($name, $customer->getName());
        $this->assertSame($address, $customer->getAddress());
        $this->assertSame($phone, $customer->getPhone());
        $this->assertSame($email, $customer->getEmail());
        $this->assertSame($actorId, $customer->getActorId());
    }
}
