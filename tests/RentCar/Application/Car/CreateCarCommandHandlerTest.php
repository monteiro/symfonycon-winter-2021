<?php

namespace App\Tests\RentCar\Application\Car;

use App\RentCar\Application\Car\CreateCarCommand;
use App\RentCar\Application\Car\CreateCarCommandHandler;
use App\Tests\RentCar\Application\TraceableDomainEventDispatcher;
use App\Tests\RentCar\Infrastructure\Persistence\InMemory\InMemoryCarRepository;
use PHPUnit\Framework\TestCase;

final class CreateCarCommandHandlerTest extends TestCase
{
    private InMemoryCarRepository $carRepository;
    private TraceableDomainEventDispatcher $domainEventDispatcher;
    private const CAR_ID = '5f3001ea-6f1c-463f-9828-d5d5a57a5b8f';

    protected function setUp(): void
    {
        $this->carRepository = new InMemoryCarRepository(self::CAR_ID);
        $this->domainEventDispatcher = new TraceableDomainEventDispatcher();
    }

    /**
     * @test
     */
    public function itShouldCreateCar(): void
    {
        // given
        $brand = 'mazda';
        $model = 'z2';
        $category = 'intermediate';
        $actorId = 'f6774efa-e40a-4e75-a26f-6aed8e08e2f5';
        $command = new CreateCarCommand($brand, $model, $category, $actorId);
        $handler = new CreateCarCommandHandler(
            $this->carRepository,
            $this->domainEventDispatcher
        );

        // when
        $handler($command);

        // then
        $this->assertCount(1, $this->carRepository->getCars());
        $this->assertCount(1, $this->domainEventDispatcher->getEvents());
        $carWasCreated = $this->domainEventDispatcher->getEvent();
        $this->assertEquals(self::CAR_ID, $carWasCreated->getAggregateRootId());
        $this->assertEquals($actorId, $carWasCreated->getActorId());
    }
}
