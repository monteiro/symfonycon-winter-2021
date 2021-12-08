<?php


namespace App\Tests\RentCar\Application;


use App\RentCar\Domain\Common\DomainEvent;
use App\RentCar\Domain\Common\DomainEventDispatcherInterface;

final class TraceableDomainEventDispatcher implements DomainEventDispatcherInterface
{
    /**
     * @var array<DomainEvent> 
     */
    private array $eventsToDispatch;
    
    public function dispatchAll(array $domainEvents): void
    {
        $this->eventsToDispatch = $domainEvents;
    }
    
    public function getEvent(): ?DomainEvent
    {
        return $this->eventsToDispatch[0] ?? null;
    }
    
    /**
     * @return DomainEvent[]
     */
    public function getEvents(): array 
    {
        return $this->eventsToDispatch;
    }
}
