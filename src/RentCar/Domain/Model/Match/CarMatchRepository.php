<?php

namespace App\RentCar\Domain\Model\Match;

interface CarMatchRepository
{
    public function save(CarMatch $carMatch): void;

    public function nextIdentity(): string;
}
