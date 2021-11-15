<?php

namespace App\RentCar\Infrastructure\Persistence\Doctrine;

use App\RentCar\Domain\Common\StoredEvent;
use App\RentCar\Domain\Common\StoredEventRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method StoredEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoredEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoredEvent[]    findAll()
 * @method StoredEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineStoredEventRepository extends ServiceEntityRepository implements StoredEventRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoredEvent::class);
    }
    
    public function append(StoredEvent $storedEvent): void
    {
        $this->getEntityManager()->persist($storedEvent);
    }

    // /**
    //  * @return RecordedDomainEvent[] Returns an array of RecordedDomainEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecordedDomainEvent
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function nextIdentity(): string
    {
        return Uuid::v4()->toRfc4122();
    }
    
    /**
     * @return array<StoredEvent>
     */
    public function nextUnpublishEvents(int $batchSize): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.published = false')
            ->orderBy('r.id', 'ASC')
            ->setMaxResults($batchSize)
            ->getQuery()
            ->getResult();   
    }

    public function save(StoredEvent $storedEvent): void
    {
        $this->getEntityManager()->persist($storedEvent);
        $this->getEntityManager()->flush();
    }
}
