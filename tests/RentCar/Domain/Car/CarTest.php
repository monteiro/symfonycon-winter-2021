<?php


namespace App\Tests\RentCar\Domain\Car;

use App\RentCar\Domain\Model\Car\Car;
use PHPUnit\Framework\TestCase;

final class CarTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateCar(): void 
    {
        $carId = '06fb00a7-e2e5-4cee-b3b4-5fae0f513a4e';
        $brand = 'bmw';
        $model = 'z2';
        $category = 'premium';
        $actorId = '3edb850b-356c-4c7b-9aed-79ad53f459e3';
        
        $car = Car::create($carId, $brand, $model, $category, $actorId);
        
        $events = $car->releaseEvents();
        $this->assertCount(1, $events);
        
        $carWasCreated = $events[0];
        $this->assertSame($carWasCreated->getAggregateRootId(), $carId);
        $this->assertSame($carWasCreated->getActorId(), $actorId);

    }
}
