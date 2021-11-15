<?php

namespace App\RentCar\Infrastructure\Persistence\Doctrine\Fixtures;

use App\RentCar\Domain\Model\Car\Car;
use App\RentCar\Domain\Model\Car\CarMatch;
use App\RentCar\Domain\Model\Car\CarRepository;
use App\RentCar\Domain\Model\Customer\Customer;
use App\RentCar\Domain\Model\Customer\CustomerRepository;
use App\RentCar\Domain\Model\Match\CarMatchRepository;
use App\RentCar\Domain\Model\Reservation\Reservation;
use App\RentCar\Domain\Model\Reservation\ReservationRepository;
use Assert\AssertionFailedException;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    private CarRepository $carRepository;
    private CustomerRepository $customerRepository;
    private ReservationRepository $reservationRepository;
    private CarMatchRepository $carMatchRepository;

    public function __construct(
        CarRepository $carRepository,
        CustomerRepository $customerRepository,
        ReservationRepository $reservationRepository,
        CarMatchRepository $carMatchRepository
    ) {

        $this->carRepository = $carRepository;
        $this->customerRepository = $customerRepository;
        $this->reservationRepository = $reservationRepository;
        $this->carMatchRepository = $carMatchRepository;
    }

    /**
     * @throws AssertionFailedException
     */
    public function load(ObjectManager $manager): void
    {
        $systemUser = Uuid::v4()->toRfc4122();
        $cars = [
            [
                'id' => $this->carRepository->nextIdentity(),
                'brand' => 'mazda',
                'model' => 'z2',
                'category' => 'standard',
                'actorId' => $systemUser
            ],
            [
                'id' => $this->carRepository->nextIdentity(),
                'brand' => 'bmw',
                'model' => 'x2',
                'category' => 'premium',
                'actorId' => $systemUser
            ],
            [
                'id' => $this->carRepository->nextIdentity(),
                'brand' => 'citroen',
                'model' => 'c4',
                'category' => 'intermediate',
                'actorId' => $systemUser
            ],
        ];

        foreach ($cars as $carFixture) {
            $this->carRepository->save(
                Car::create(
                    $carFixture['id'],
                    $carFixture['brand'],
                    $carFixture['model'],
                    $carFixture['category'],
                    $carFixture['actorId']
                )
            );
        }
        $manager->flush();

        $customers = [
            [
                'id' => $this->customerRepository->nextIdentity(),
                'name' => 'John Due',
                'address' => '57 The Avenue London',
                'phone' => '+447911123456',
                'email' => 'johndue@test.com'
            ],
            [
                'id' => $this->customerRepository->nextIdentity(),
                'name' => 'Mira Skyer',
                'address' => '61 King Street London',
                'phone' => '+447911123456',
                'email' => 'miraskyer@test.com'
            ],
            [
                'id' => $this->customerRepository->nextIdentity(),
                'name' => 'Jean Paul',
                'address' => '253 Albert Road London',
                'phone' => '+447911123456',
                'email' => 'jeanpaul@test.com'
            ],
        ];

        foreach ($customers as $customer) {
            $this->customerRepository->save(
                Customer::create(
                    $customer['id'],
                    $customer['name'],
                    $customer['address'],
                    $customer['phone'],
                    $customer['email'],
                    $systemUser
                )
            );
        }
        $manager->flush();

        $reservations = [
            [
                'id' => $this->reservationRepository->nextIdentity(),
                'location' => '40 The Green London',
                'pickUp' => new \DateTimeImmutable('2021-12-01 14:00:00'),
                'returnAt' => new \DateTimeImmutable('2021-12-05 18:00:00'),
                'category' => 'premium',
                'status' => 'pending',
                'customer' => $this->customerRepository->findById($customers[0]['id'])
            ],
            [
                'id' => $this->reservationRepository->nextIdentity(),
                'location' => '40 The Green London',
                'pickUp' => new \DateTimeImmutable('2021-12-01 14:00:00'),
                'returnAt' => new \DateTimeImmutable('2021-12-05 18:00:00'),
                'category' => 'premium',
                'status' => 'pending',
                'customer' => $this->customerRepository->findById($customers[1]['id'])
            ],
            [
                'id' => $this->reservationRepository->nextIdentity(),
                'location' => '40 The Green London',
                'pickUp' => new \DateTimeImmutable('2021-12-01 14:00:00'),
                'returnAt' => new \DateTimeImmutable('2021-12-05 18:00:00'),
                'category' => 'standard',
                'status' => 'pending',
                'customer' => $this->customerRepository->findById($customers[2]['id'])
            ]
        ];

        foreach($reservations as $reservation) {
            $this->reservationRepository->save(
                Reservation::create(
                    $reservation['id'],
                    $reservation['location'],
                    $reservation['pickUp'],
                    $reservation['returnAt'],
                    $reservation['category'],
                    $systemUser,
                    $reservation['customer'],
                )
            );
        }
        $manager->flush();

        $matches = [
            [
                'id' => $this->carMatchRepository->nextIdentity(),
                'reservation' => $this->reservationRepository->findById(
                    $reservations[0]['id']
                ),
                'car' => $cars[0]['id']
            ],
            [
                'id' => $this->carMatchRepository->nextIdentity(),
                'reservation' => $this->reservationRepository->findById(
                    $reservations[1]['id']
                ),
                'car' => $cars[1]['id']
            ],
            [
                'id' => $this->carMatchRepository->nextIdentity(),
                'reservation' => $this->reservationRepository->findById(
                    $reservations[2]['id']
                ),
                'car' => $cars[2]['id']
            ],
        ];

        foreach($matches as $match) {
            $this->carMatchRepository->save(
                CarMatch::match(
                    $this->carMatchRepository->nextIdentity(),
                    $match['reservation'],
                    $this->carRepository,
                )
            );
        }
        $manager->flush();
    }
}
