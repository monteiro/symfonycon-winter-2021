<?php

namespace App\RentCar\Infrastructure\Symfony\Controller;

use App\RentCar\Application\Car\CreateCarCommand;
use App\RentCar\Infrastructure\Symfony\Security\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

final class CarController
{
    #[Route('/cars', name: 'app_cars', methods: ['POST'])]
    public function create(
        Request $request,
        MessageBusInterface $bus,
        User $user
    ): Response {
        $body = $request->toArray();

        $envelope = $bus->dispatch(
            new CreateCarCommand(
                $body['brand'] ?? null,
                $body['model'] ?? null,
                $body['category'] ?? null,
                $user->getUserIdentifier()
            )
        );

        return new JsonResponse([
            'id' => $envelope->last(HandledStamp::class)?->getResult(),
        ], Response::HTTP_CREATED);
    }
}
