<?php

namespace App\RentCar\Domain\Common;

interface DomainEventDispatcherInterface
{
    /**
     * @param array<DomainEvent> $domainEvents
     */
    public function dispatchAll(array $domainEvents): void;
}
