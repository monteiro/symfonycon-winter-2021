<?php

namespace App\RentCar\Application\Match;

final class CreateCarMatchCommand
{
    private string $reservationId;

    public function __construct(string $reservationId)
    {
        $this->reservationId = $reservationId;
    }

    public function getReservationId(): string
    {
        return $this->reservationId;
    }
}
