<?php


namespace App\RentCar\Application;


use App\RentCar\Domain\Common\DomainEvent;
use App\RentCar\Domain\Common\DomainEventDispatcherInterface;
use App\RentCar\Domain\Common\StoredEvent;
use App\RentCar\Domain\Common\StoredEventRepository;
use App\RentCar\Infrastructure\Persistence\Doctrine\DoctrineStoredEventRepository;
use Symfony\Component\Serializer\SerializerInterface;

final class DomainEventDispatcher implements DomainEventDispatcherInterface
{
    private StoredEventRepository $storedEventRepository;
    private SerializerInterface $serializer;

    public function __construct(
        StoredEventRepository $storedEventRepository,
        SerializerInterface $serializer
    ) {
        $this->storedEventRepository = $storedEventRepository;
        $this->serializer = $serializer;
    }

    /**
     * @param array<DomainEvent> $domainEvents
     */
    public function dispatchAll(array $domainEvents): void
    {
        foreach($domainEvents as $domainEvent) {
            $this->storedEventRepository->append(new StoredEvent(
                $this->storedEventRepository->nextIdentity(),
                get_class($domainEvent),
                $this->serializer->serialize($domainEvent, 'json'),
                $domainEvent->getAggregateRootId(),
                $domainEvent->getActorId(),
                )
            );    
        }
    }
}
