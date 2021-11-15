<?php

namespace App\RentCar\Domain\Model\Car;

use App\RentCar\Domain\Common\AggregateRoot;
use App\RentCar\Domain\Model\Customer\Customer;
use App\RentCar\Domain\Model\Reservation\Reservation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CarMatch
{
    use AggregateRoot;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=32)
     */
    private string $id;

    /**
     * @ORM\OneToOne(targetEntity="App\RentCar\Domain\Model\Reservation\Reservation")
     */
    private Reservation $reservation;

    /**
     * @ORM\ManyToOne(targetEntity="App\RentCar\Domain\Model\Car\Car")
     */
    private Car $car;
    
    public static function match(string $matchId, Reservation $reservation, CarRepository $carRepository) {
        $car = $carRepository->findOneByCategory($reservation->getCategory());
        
        return new self(
            $matchId,
            $reservation,
            $car
        );
    }

    /**
     * @param string $id
     * @param Reservation $reservation
     * @param Car $car
     */
    public function __construct(string $id, Reservation $reservation, Car $car)
    {
        $this->id          = $id;
        $this->reservation = $reservation;
        $this->car         = $car;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Reservation
     */
    public function getReservation(): Reservation
    {
        return $this->reservation;
    }

    /**
     * @return Car
     */
    public function getCar(): Car
    {
        return $this->car;
    }
}
