<?php

namespace App\RentCar\Domain\Model\Match;

use App\DDDBundle\Domain\AggregateRoot;
use App\RentCar\Domain\Model\Car\Car;
use App\RentCar\Domain\Model\Car\CarRepository;
use App\RentCar\Domain\Model\Reservation\Reservation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CarMatch
{
    use AggregateRoot;
    
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: "string", length: 36)]
    private string $id;
    
    #[ORM\OneToOne(targetEntity: Reservation::class)]
    private Reservation $reservation;
    
    #[ORM\ManyToOne(targetEntity: Car::class)]
    private Car $car;

    public static function match(string $matchId, Reservation $reservation, CarRepository $carRepository): self
    {
        $car = $carRepository->findOneByCategory($reservation->getCategory());

        return new self(
            $matchId,
            $reservation,
            $car
        );
    }

    public function __construct(string $id, Reservation $reservation, Car $car)
    {
        $this->id = $id;
        $this->reservation = $reservation;
        $this->car = $car;
        $this->record(new CarWasMatched($id));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getReservation(): Reservation
    {
        return $this->reservation;
    }

    public function getCar(): Car
    {
        return $this->car;
    }
}
