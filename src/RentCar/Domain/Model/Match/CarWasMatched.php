<?php
namespace App\RentCar\Domain\Model\Match;

use App\DDDBundle\Domain\DomainEvent;

final class CarWasMatched implements DomainEvent
{
    private string $id;
    private \DateTimeImmutable $occurredOn;

    public function __construct(string $aggregateRootId)
    {
        $this->id = $aggregateRootId;
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

    public function getUserId(): ?string
    {
        return null;
    }
}