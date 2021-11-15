<?php

namespace App\RentCar\Infrastructure\Persistence\Doctrine;

use App\RentCar\Domain\Model\Reservation\Reservation;
use App\RentCar\Domain\Model\Reservation\ReservationNotFoundException;
use App\RentCar\Domain\Model\Reservation\ReservationRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineReservationRepository extends ServiceEntityRepository implements ReservationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }
    
    public function save(Reservation $reservation): void
    {
        $this->getEntityManager()->persist($reservation);
    }

    public function nextIdentity(): string
    {
        return Uuid::v4()->toRfc4122();
    }

    public function findById(string $reservationId): Reservation
    {
        $reservation = $this->findOneBy(['id' => $reservationId]);
        if (!$reservation) {
            throw ReservationNotFoundException::withId($reservationId);
        }
        
        return $reservation;
    }
}
