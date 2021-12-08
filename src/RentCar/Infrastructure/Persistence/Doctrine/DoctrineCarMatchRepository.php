<?php

namespace App\RentCar\Infrastructure\Persistence\Doctrine;

use App\RentCar\Domain\Model\Match\CarMatch;
use App\RentCar\Domain\Model\Match\CarMatchRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method CarMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarMatch[]    findAll()
 * @method CarMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineCarMatchRepository extends ServiceEntityRepository implements CarMatchRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarMatch::class);
    }
    
    public function save(CarMatch $carMatch): void
    {
        $this->getEntityManager()->persist($carMatch);
    }

    public function nextIdentity(): string
    {
        return Uuid::v4()->toRfc4122();
    }
}
