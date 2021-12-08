<?php
namespace App\RentCar\Application\Car;

use App\RentCar\Domain\Common\DomainEventDispatcherInterface;
use App\RentCar\Domain\Model\Car\Car;
use App\RentCar\Domain\Model\Car\CarRepository;

final class CreateCarCommandHandler
{
    private CarRepository $carRepository;
    private DomainEventDispatcherInterface $domainEventDispatcher;

    public function __construct(CarRepository $carRepository, DomainEventDispatcherInterface $domainEventDispatcher) 
    {

        $this->carRepository = $carRepository;
        $this->domainEventDispatcher = $domainEventDispatcher;
    }
    
    public function __invoke(CreateCarCommand $command): string
    {
        $newCar = Car::create(
            $this->carRepository->nextIdentity(),
            $command->getBrand(),
            $command->getModel(),
            $command->getCategory(),
            $command->getActorId()
        );
        
        $this->carRepository->save($newCar);
        $this->domainEventDispatcher->dispatchAll($newCar->releaseEvents());
        
        return $newCar->getId();
    }
}
