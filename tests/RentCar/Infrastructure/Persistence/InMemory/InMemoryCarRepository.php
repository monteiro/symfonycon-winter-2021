<?php


namespace App\Tests\RentCar\Infrastructure\Persistence\InMemory;


use App\RentCar\Domain\Model\Car\Car;
use App\RentCar\Domain\Model\Car\CarForCategoryNotFoundException;
use App\RentCar\Domain\Model\Car\CarRepository;

final class InMemoryCarRepository implements CarRepository
{
    /**
     * @var array<Car>
     */
    private array $cars = [];
    private ?string $uuid;

    public function __construct(?string $uuid = null) {

        $this->uuid = $uuid;
    }

    public function save(Car $car): void
    {
        $this->cars[$car->getId()] = $car;
    }

    public function findOneByCategory(string $category): Car
    {
        foreach($this->cars as $car) {
            if ($car->getCategory() === $category) {
                return $car;
            }
        }
        
        throw CarForCategoryNotFoundException::withCategory($category);
    }

    public function nextIdentity(): string
    {
        if ($this->uuid) {
            return $this->uuid;
        }
        
        return '0970424c-d5a1-4af7-b2dd-872c0edf5f3f';
    }
    
    public function getCars(): array 
    {
        return $this->cars;
    }
}
