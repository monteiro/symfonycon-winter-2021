<?php

namespace App\Tests\RentCar\Infrastructure\Persistence\InMemory;

use App\RentCar\Domain\Model\Match\CarMatch;
use App\RentCar\Domain\Model\Match\CarMatchRepository;

final class InMemoryCarMatchRepository implements CarMatchRepository
{
    /**
     * @var array<CarMatch>
     */
    private array $carMatches = [];
    private ?string $uuid;

    public function __construct(?string $uuid = null)
    {
        $this->uuid = $uuid;
    }

    public function save(CarMatch $carMatch): void
    {
        $this->carMatches[$carMatch->getId()] = $carMatch;
    }

    public function nextIdentity(): string
    {
        if ($this->uuid) {
            return $this->uuid;
        }

        return '0970424c-d5a1-4af7-b2dd-872c0edf5f3f';
    }

    public function getCarMatches(): array
    {
        return $this->carMatches;
    }
}
