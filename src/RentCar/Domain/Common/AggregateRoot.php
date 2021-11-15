<?php
namespace App\RentCar\Domain\Common;

trait AggregateRoot
{
    private array $recordedEvents;
    
    public function record(DomainEvent $event): void 
    {
        $this->recordedEvents[] = $event;
    }
    
    public function releaseEvents(): array 
    {
        $recordedEvents = $this->recordedEvents;
        $this->recordedEvents = [];
        
        return $recordedEvents;
    }
}
