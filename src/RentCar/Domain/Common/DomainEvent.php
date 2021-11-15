<?php
namespace App\RentCar\Domain\Common;

interface DomainEvent
{
    public function getAggregateRootId(): string;
    
    public function getActorId(): ?string;

    public function getOccurredOn(): \DateTimeImmutable;
}
