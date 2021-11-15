<?php


namespace App\RentCar\Application\External;


use App\RentCar\Domain\Model\Customer\CustomerWasCreated;
use Psr\Log\LoggerInterface;

final class CustomerWasCreatedHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(CustomerWasCreated $customerWasCreated)
    {
        $this->logger->info(
            sprintf('the customer "%s" has been created. Send a welcoming email', $customerWasCreated->getAggregateRootId())
        );
    }
}
