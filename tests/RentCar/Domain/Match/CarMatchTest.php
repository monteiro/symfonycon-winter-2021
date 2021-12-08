<?php

namespace App\Tests\RentCar\Domain\Match;

use App\RentCar\Domain\Model\Car\CarForCategoryNotFoundException;
use App\RentCar\Domain\Model\Match\CarMatch;
use App\RentCar\Domain\Model\Match\CarWasMatched;
use App\Tests\RentCar\Domain\RentCarMother;
use App\Tests\RentCar\Infrastructure\Persistence\InMemory\InMemoryCarRepository;
use PHPUnit\Framework\TestCase;

final class CarMatchTest extends TestCase
{
    private const MATCH_ID = '6744435b-84bc-423b-ba42-507457ee75f3';
    private InMemoryCarRepository $carRepository;

    protected function setUp(): void
    {
        $this->carRepository = new InMemoryCarRepository();
    }

    /**
     * @test
     */
    public function itShouldMatchCar(): void
    {
        $car = RentCarMother::aCar('premium');
        $this->carRepository->save($car);

        $reservation = RentCarMother::aReservation(RentCarMother::aCustomer());
        $carMatch = CarMatch::match(
            self::MATCH_ID,
            $reservation,
            $this->carRepository
        );

        $this->assertSame(self::MATCH_ID, $carMatch->getId());
        $this->assertSame($reservation, $carMatch->getReservation());
        $this->assertSame($car, $carMatch->getCar());

        $events = $carMatch->releaseEvents();
        $this->assertCount(1, $events);

        $carWasMatched = $events[0];
        $this->assertInstanceOf(CarWasMatched::class, $carWasMatched);

        $this->assertSame($carMatch->getId(), $carWasMatched->getAggregateRootId());
        $this->assertNull($carWasMatched->getActorId());
    }

    /**
     * @test
     */
    public function itShouldNotMatchIfCarNotFound(): void
    {
        $this->expectException(CarForCategoryNotFoundException::class);
        CarMatch::match(
            self::MATCH_ID,
            RentCarMother::aReservation(RentCarMother::aCustomer()),
            $this->carRepository
        );
    }
}
