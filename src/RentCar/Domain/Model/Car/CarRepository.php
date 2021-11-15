<?php

namespace App\RentCar\Domain\Model\Car;

interface CarRepository
{
    public function save(Car $car): void;
    public function findOneByCategory(string $category): Car;
    public function nextIdentity(): string;
}
