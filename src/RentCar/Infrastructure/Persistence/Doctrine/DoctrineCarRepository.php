<?php

namespace App\RentCar\Infrastructure\Persistence\Doctrine;

use App\RentCar\Domain\Model\Car\Car;
use App\RentCar\Domain\Model\Car\CarForCategoryNotFoundException;
use App\RentCar\Domain\Model\Car\CarRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineCarRepository extends ServiceEntityRepository implements CarRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    // /**
    //  * @return Car[] Returns an array of Car objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Car
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function save(Car $car): void
    {
        $this->getEntityManager()->persist($car);
    }
    
    public function nextIdentity(): string
    {
        return Uuid::v4()->toRfc4122();
    }

    public function findOneByCategory(string $category): Car
    {
        $car = $this->findOneBy([
            'category' => $category
        ]);
        
        if (!$car) {
            throw CarForCategoryNotFoundException::withCategory($category);
        }
        
        return $car;
    }
}
