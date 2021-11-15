<?php


namespace App\RentCar\Domain\Model\Reservation;


use App\RentCar\Domain\Common\DomainEvent;

final class ReservationWasCancelled implements DomainEvent
{
    private string $id;
    private \DateTimeImmutable $occurredOn;
    private string $actorId;
    
    public function __construct(string $aggregateRootId, string $actorId)
    {
        $this->id = $aggregateRootId;
        $this->actorId = $actorId;
        $this->occurredOn = new \DateTimeImmutable();
    }
    
    public function getAggregateRootId(): string
    {
        return $this->id;
    }

    public function getOccurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function getActorId(): ?string
    {
        return $this->actorId;
    }
}
