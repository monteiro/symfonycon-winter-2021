<?php

namespace App\Tests\RentCar\Application\Customer;

use App\RentCar\Application\Customer\CreateCustomerCommand;
use App\RentCar\Application\Customer\CreateCustomerCommandHandler;
use App\Tests\RentCar\Application\TraceableDomainEventDispatcher;
use App\Tests\RentCar\Infrastructure\Persistence\InMemory\InMemoryCustomerRepository;
use PHPUnit\Framework\TestCase;

final class CreateCustomerCommandHandlerTest extends TestCase
{
    private InMemoryCustomerRepository $customerRepository;
    private TraceableDomainEventDispatcher $domainEventDispatcher;
    private const CUSTOMER_ID = '28300449-e69f-432c-b349-2e8e8b57a1f4';

    protected function setUp(): void
    {
        $this->customerRepository = new InMemoryCustomerRepository(self::CUSTOMER_ID);
        $this->domainEventDispatcher = new TraceableDomainEventDispatcher();
    }

    /**
     * @test
     */
    public function itShouldNotCreateCustomerWrongEmailFormat(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $actorId = 'f6774efa-e40a-4e75-a26f-6aed8e08e2f5';
        $command = new CreateCustomerCommand('John Doe', 'Rue Paris, 122', '+44210902191', 'WRONG_EMAIL_FORMAT', $actorId);
        $handler = new CreateCustomerCommandHandler(
            $this->customerRepository,
            $this->domainEventDispatcher
        );

        $handler($command);
    }

    /**
     * @test
     */
    public function itShouldCreateCustomer(): void
    {
        // given
        $actorId = 'f6774efa-e40a-4e75-a26f-6aed8e08e2f5';
        $command = new CreateCustomerCommand('John Doe', 'Rue Paris, 122', '+44210902191', 'johndoe@test.com', $actorId);
        $handler = new CreateCustomerCommandHandler(
            $this->customerRepository,
            $this->domainEventDispatcher
        );

        // when
        $handler($command);

        // then
        $this->assertCount(1, $this->customerRepository->getCustomers());
        $this->assertCount(1, $this->domainEventDispatcher->getEvents());
        $carWasCreated = $this->domainEventDispatcher->getEvent();
        $this->assertEquals(self::CUSTOMER_ID, $carWasCreated->getAggregateRootId());
        $this->assertEquals($actorId, $carWasCreated->getActorId());
    }
}
