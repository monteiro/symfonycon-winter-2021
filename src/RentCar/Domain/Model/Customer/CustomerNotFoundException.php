<?php


namespace App\RentCar\Domain\Model\Customer;


final class CustomerNotFoundException extends \DomainException
{
    public static function withId(string $customerId) {
        return new self(
            sprintf('The customer with id "%s" does not exist!', $customerId)
        );
    }
}