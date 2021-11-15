<?php

namespace App\RentCar\Infrastructure\Persistence\Doctrine;

use App\RentCar\Domain\Model\Customer\Customer;
use App\RentCar\Domain\Model\Customer\CustomerNotFoundException;
use App\RentCar\Domain\Model\Customer\CustomerRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineCustomerRepository extends ServiceEntityRepository implements CustomerRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    // /**
    //  * @return Customer[] Returns an array of Customer objects
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
    public function findOneBySomeField($value): ?Customer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function save(Customer $customer): void
    {
        $this->getEntityManager()->persist($customer);
    }

    public function nextIdentity(): string
    {
        return Uuid::v4()->toRfc4122();
    }

    public function findById(string $customerId): Customer
    {
        $customer =  $this->findOneBy([
            'id' => $customerId
        ]);
        
        if (!$customer) {
            throw CustomerNotFoundException::withId($customerId);
        }
        
        return $customer;
    }
}
