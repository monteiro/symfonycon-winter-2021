<?php


namespace App\Tests\RentCar\Application;


use App\DDDBundle\Domain\DomainEvent;
use App\DDDBundle\Domain\DomainEventDispatcherInterface;

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
