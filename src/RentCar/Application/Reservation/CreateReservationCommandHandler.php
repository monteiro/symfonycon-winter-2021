<?php


namespace App\RentCar\Application\Reservation;


use App\RentCar\Domain\Model\Customer\CustomerRepository;
use App\RentCar\Domain\Model\Reservation\Reservation;
use App\RentCar\Domain\Model\Reservation\ReservationRepository;

final class CreateReservationCommandHandler
{
    private ReservationRepository $reservationRepository;
    private CustomerRepository $customerRepository;

    public function __construct(ReservationRepository $reservationRepository, CustomerRepository $customerRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->customerRepository    = $customerRepository;
    }

    public function __invoke(CreateReservationCommand $command)
    {
        $customer = $this->customerRepository->findById($command->getCustomerId());

        $reservation = Reservation::create(
            $this->reservationRepository->nextIdentity(),
            $command->getLocation(),
            $command->getPickUpAt(),
            $command->getReturnAt(),
            $command->getCategory(),
            $command->getActorId(),
            $customer
        );
        
        $this->reservationRepository->save($reservation);
        
        return $reservation->getId();
    }
}