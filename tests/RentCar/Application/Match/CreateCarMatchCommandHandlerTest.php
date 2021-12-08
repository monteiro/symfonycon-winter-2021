<?php

namespace App\Tests\RentCar\Application\Match;

use App\RentCar\Application\Match\CreateCarMatchCommand;
use App\RentCar\Application\Match\CreateCarMatchCommandHandler;
use App\Tests\RentCar\Application\TraceableDomainEventDispatcher;
use App\Tests\RentCar\Domain\RentCarMother;
use App\Tests\RentCar\Infrastructure\Persistence\InMemory\InMemoryCarMatchRepository;
use App\Tests\RentCar\Infrastructure\Persistence\InMemory\InMemoryCarRepository;
use App\Tests\RentCar\Infrastructure\Persistence\InMemory\InMemoryReservationRepository;
use PHPUnit\Framework\TestCase;

final class CreateCarMatchCommandHandlerTest extends TestCase
{
    private InMemoryCarMatchRepository $carMatchRepository;
    private InMemoryReservationRepository $reservationRepository;
    private InMemoryCarRepository $carRepository;
    private TraceableDomainEventDispatcher $domainEventDispatcher;

    private const CAR_ID = '5f3001ea-6f1c-463f-9828-d5d5a57a5b8f';

    protected function setUp(): void
    {
        $this->carMatchRepository = new InMemoryCarMatchRepository();
        $this->carRepository = new InMemoryCarRepository(self::CAR_ID);
        $this->reservationRepository = new InMemoryReservationRepository();
        $this->domainEventDispatcher = new TraceableDomainEventDispatcher();
    }

    /**
     * @test
     */
    public function itShouldCreateCarMatch(): void
    {
        // given
        $car = RentCarMother::aCar('premium');
        $this->carRepository->save($car);
        $customer = RentCarMother::aCustomer();

        $reservation = RentCarMother::aReservation($customer);
        $this->reservationRepository->save($reservation);

        $command = new CreateCarMatchCommand($reservation->getId());
        $handler = new CreateCarMatchCommandHandler(
            $this->reservationRepository,
            $this->carRepository,
            $this->carMatchRepository
        );

        // when
        $carMatchId = $handler($command);

        // then
        $this->assertNotNull($carMatchId);
    }
}
