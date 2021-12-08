<?php

namespace App\Tests\RentCar\Domain\Reservation;

use App\RentCar\Domain\Model\Customer\Customer;
use App\RentCar\Domain\Model\Reservation\Reservation;
use App\RentCar\Domain\Model\Reservation\ReservationWasCancelled;
use App\RentCar\Domain\Model\Reservation\ReservationWasCreated;
use PHPUnit\Framework\TestCase;

final class ReservationTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateReservation(): void
    {
        $reservationId = '2696bee0-a1e3-4e78-b09d-01a5fedbcbc8';
        $location = 'Rua do Ouro';
        $pickUpAt = new \DateTimeImmutable('2021-01-01 14:00');
        $returnAt = new \DateTimeImmutable('2021-01-20 14:00');
        $category = 'premium';
        $actorId = 'ee4b8904-a53e-4121-bea8-9ac53dcbf58e';
        $customer = Customer::create(
            '970656c1-dd7b-42bd-bea4-4577fa175c72',
            'John Doe',
            'Rue Paris, 122',
            '+4412981981',
            'johndoe@test.com',
            $actorId
        );

        $reservation = Reservation::create(
            $reservationId,
            $location,
            $pickUpAt,
            $returnAt,
            $category,
            $actorId,
            $customer
        );

        $events = $reservation->releaseEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(ReservationWasCreated::class, $events[0]);

        $reservationWasCreated = $events[0];
        $this->assertSame($reservationWasCreated->getAggregateRootId(), $reservationId);
        $this->assertSame($reservationWasCreated->getActorId(), $actorId);

        $this->assertSame('pending', $reservation->getStatus());
        $this->assertSame($actorId, $reservation->getActorId());
        $this->assertSame($reservationId, $reservation->getId());
        $this->assertSame($category, $reservation->getCategory());
        $this->assertSame($location, $reservation->getLocation());
        $this->assertSame($pickUpAt, $reservation->getPickUpAt());
        $this->assertSame($returnAt, $reservation->getReturnAt());
    }

    /**
     * @test
     */
    public function itShouldCancelReservation(): void
    {
        $actorId = 'c807779b-ad5e-42e8-954e-c0f193fe6375';

        $customer = Customer::create(
            '4923038f-28e4-4921-a7f7-cf71a7e44883',
            'Hugo Monteiro',
            'Rua do Ouro, Lisboa',
            '+35196271231',
            'hugo@test.com',
            $actorId
        );

        $reservation = Reservation::create(
            '0e3d7e91-3b09-4dd9-ae20-5fe6acc4c2d2',
            'Rua da Prata, 22',
            new \DateTimeImmutable('2021-12-09 14:00:00'),
            new \DateTimeImmutable('2021-12-12 14:00:00'),
            'premium',
            'd0e7c215-f9d5-4818-bba4-c00d416fafe5',
            $customer
        );
        $reservation->releaseEvents();

        $reservation->cancel($actorId);
        $this->assertSame('cancelled', $reservation->getStatus());

        $events = $reservation->releaseEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(ReservationWasCancelled::class, $events[0]);

        $reservationWasCancelled = $events[0];
        $this->assertSame($reservationWasCancelled->getAggregateRootId(), '0e3d7e91-3b09-4dd9-ae20-5fe6acc4c2d2');
        $this->assertSame($reservationWasCancelled->getActorId(), $actorId);
    }
}
