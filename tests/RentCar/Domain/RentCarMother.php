<?php

namespace App\Tests\RentCar\Domain;

use App\RentCar\Domain\Model\Car\Car;
use App\RentCar\Domain\Model\Customer\Customer;
use App\RentCar\Domain\Model\Reservation\Reservation;

final class RentCarMother
{
    public const ACTOR_ID = '3e6bee9b-c8ed-4fa1-864a-69a5487f8ee4';

    public static function aCustomer(): Customer
    {
        return Customer::create(
            'c1a848cb-07e8-4c04-8dcb-9adc82f276e7',
            'John Doe',
            'Rua do Ouro',
            '+35120930191',
            'johndoe@test.com',
            self::ACTOR_ID
        );
    }

    public static function aReservation(Customer $customer): Reservation
    {
        return Reservation::create(
            '3717f3aa-734d-4d4d-8cb2-6d88bfad3cc2',
            'Rue Paris, 122',
            new \DateTimeImmutable('2021-01-01 10:00'),
            new \DateTimeImmutable('2021-01-01 14:00'),
            'premium',
            self::ACTOR_ID,
            $customer
        );
    }

    public static function aCar(string $category): Car
    {
        return Car::create(
            '2c30944c-9127-44c2-b4ec-859d387ac61b',
            'bmw',
            'z3',
            $category,
            self::ACTOR_ID
        );
    }
}
