<?php

namespace App\RentCar\Domain\Model\Reservation;

interface ReservationRepository
{
    public function save(Reservation $reservation): void;

    /**
     * @throws ReservationNotFoundException
     */
    public function findById(string $reservationId): Reservation;
    
    public function nextIdentity(): string;
}
