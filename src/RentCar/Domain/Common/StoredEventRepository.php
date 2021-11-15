<?php

namespace App\RentCar\Domain\Common;

interface StoredEventRepository
{
    public function append(StoredEvent $storedEvent): void;

    /**
     * @return array<StoredEvent>
     */
    public function nextUnpublishEvents(int $batchSize): array;
    
    public function nextIdentity(): string;
    
    public function save(StoredEvent $storedEvent): void;
}
