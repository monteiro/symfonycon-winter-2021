<?php

namespace App\Tests\RentCar\Infrastructure\Persistence\InMemory;

use App\RentCar\Domain\Model\Reservation\Reservation;
use App\RentCar\Domain\Model\Reservation\ReservationNotFoundException;
use App\RentCar\Domain\Model\Reservation\ReservationRepository;

final class InMemoryReservationRepository implements ReservationRepository
{
    /**
     * @var array<Reservation>
     */
    private array $reservations = [];
    private ?string $uuid;

    public function __construct(?string $uuid = null)
    {
        $this->uuid = $uuid;
    }

    public function save(Reservation $reservation): void
    {
        $this->reservations[$reservation->getId()] = $reservation;
    }

    public function nextIdentity(): string
    {
        if ($this->uuid) {
            return $this->uuid;
        }

        return '0970424c-d5a1-4af7-b2dd-872c0edf5f3f';
    }

    public function getReservations(): array
    {
        return $this->reservations;
    }

    public function findById(string $reservationId): Reservation
    {
        if (isset($this->reservations[$reservationId])) {
            return $this->reservations[$reservationId];
        }

        throw ReservationNotFoundException::withId($reservationId);
    }
}
