<?php
namespace App\RentCar\Application\Reservation;

use App\DDDBundle\Domain\DomainEventDispatcherInterface;
use App\RentCar\Domain\Model\Reservation\ReservationRepository;

final class CancelReservationCommandHandler
{
    private ReservationRepository $reservationRepository;
    private DomainEventDispatcherInterface $domainEventDispatcher;

    public function __construct(
        ReservationRepository $reservationRepository,
        DomainEventDispatcherInterface $domainEventDispatcher
    ) {
        $this->reservationRepository = $reservationRepository;
        $this->domainEventDispatcher = $domainEventDispatcher;
    }

    public function __invoke(CancelReservationCommand $command)
    {
        $reservation = $this->reservationRepository->findById($command->getReservationId());
        
        $reservation->cancel($command->getActorId());
        $this->reservationRepository->save($reservation);
        $this->domainEventDispatcher->dispatchAll($reservation->releaseEvents());
    }
}
