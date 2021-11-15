<?php

namespace App\RentCar\Domain\Model\Match;

use App\RentCar\Domain\Model\Car\CarMatch;

interface CarMatchRepository
{
    public function save(CarMatch $carMatch): void;
    public function nextIdentity(): string;
}
