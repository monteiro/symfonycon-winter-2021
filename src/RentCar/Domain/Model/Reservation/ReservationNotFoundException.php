<?php


namespace App\RentCar\Domain\Model\Reservation;

final class ReservationNotFoundException extends \DomainException
{
    public static function withId(string $id) {
        return new self(
            sprintf('The reservation with id "%s" was not found', $id));
    }
}
