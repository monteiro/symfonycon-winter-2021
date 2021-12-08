<?php

namespace App\RentCar\Application\Match;

use App\RentCar\Domain\Model\Car\CarRepository;
use App\RentCar\Domain\Model\Match\CarMatch;
use App\RentCar\Domain\Model\Match\CarMatchRepository;
use App\RentCar\Domain\Model\Reservation\ReservationRepository;

final class CreateCarMatchCommandHandler
{
    private ReservationRepository $reservationRepository;
    private CarMatchRepository $carMatchRepository;
    private CarRepository $carRepository;

    public function __construct(
        ReservationRepository $reservationRepository,
        CarRepository $carRepository,
        CarMatchRepository $carMatchRepository
    ) {
        $this->reservationRepository = $reservationRepository;
        $this->carRepository = $carRepository;
        $this->carMatchRepository = $carMatchRepository;
    }

    public function __invoke(CreateCarMatchCommand $command): string
    {
        $reservation = $this->reservationRepository->findById($command->getReservationId());
        $carMatch = CarMatch::match(
            $this->carMatchRepository->nextIdentity(),
            $reservation,
            $this->carRepository
        );

        $this->carMatchRepository->save($carMatch);

        return $carMatch->getId();
    }
}
