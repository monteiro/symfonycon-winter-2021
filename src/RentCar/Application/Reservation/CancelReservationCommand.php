<?php


namespace App\RentCar\Application\Reservation;


final class CancelReservationCommand
{
    private string $reservationId;
    private string $actorId;

    /**
     * @param string $reservationId
     * @param string $actorId
     */
    public function __construct(string $reservationId, string $actorId)
    {
        $this->reservationId = $reservationId;
        $this->actorId       = $actorId;
    }

    /**
     * @return string
     */
    public function getReservationId(): string
    {
        return $this->reservationId;
    }

    /**
     * @return string
     */
    public function getActorId(): string
    {
        return $this->actorId;
    }
}