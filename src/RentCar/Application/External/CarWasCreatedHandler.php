<?php


namespace App\RentCar\Application\External;


use App\RentCar\Domain\Model\Car\CarWasCreated;
use App\RentCar\Domain\Model\Customer\CustomerWasCreated;
use Psr\Log\LoggerInterface;

final class CarWasCreatedHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(CarWasCreated $carWasCreated)
    {
        $this->logger->info(
            sprintf('the car "%s" has been created. Upgrade list of cars projection?', $carWasCreated->getAggregateRootId())
        );
    }
}
