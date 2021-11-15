<?php
namespace App\RentCar\Application\Customer;

use App\RentCar\Domain\Common\DomainEventDispatcherInterface;
use App\RentCar\Domain\Model\Customer\Customer;
use App\RentCar\Domain\Model\Customer\CustomerRepository;
use Assert\AssertionFailedException;

final class CreateCustomerCommandHandler
{
    private CustomerRepository $customerRepository;
    private DomainEventDispatcherInterface $domainEventDispatcher;

    public function __construct(CustomerRepository $customerRepository, DomainEventDispatcherInterface $domainEventDispatcher) 
    {

        $this->customerRepository    = $customerRepository;
        $this->domainEventDispatcher = $domainEventDispatcher;
    }

    /**
     * @throws AssertionFailedException
     */
    public function __invoke(CreateCustomerCommand $command) 
    {
        $customer = Customer::create(
            $this->customerRepository->nextIdentity(),
            $command->getName(),
            $command->getAddress(),
            $command->getPhone(),
            $command->getEmail(),
            $command->getActorId()
        );
        
        $this->customerRepository->save($customer);
        $this->domainEventDispatcher->dispatchAll($customer->releaseEvents());
        
        return $customer->getId();
    }
}
