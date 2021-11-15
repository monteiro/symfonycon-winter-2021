<?php


namespace App\RentCar\Domain\Model\Car;


final class CarForCategoryNotFoundException extends \DomainException
{
    public static function withCategory(string $category)  {
        return new self(
            sprintf('Car not found for category "%s"', $category)
        );
    }
}