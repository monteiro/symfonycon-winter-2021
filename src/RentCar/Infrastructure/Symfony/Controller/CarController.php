<?php

namespace App\RentCar\Infrastructure\Symfony\Controller;

use App\RentCar\Application\Car\CreateCarCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

final class CarController
{
    /**
     * @Route("/cars", name="app_cars", methods={"POST"})
     */
    public function create(
        Request $request,
        MessageBusInterface $bus,
        Security $security
    ): Response {
        $body = $request->toArray();

        $envelope = $bus->dispatch(
            new CreateCarCommand(
                $body['brand'] ?? null,
                $body['model'] ?? null,
                $body['category'] ?? null,
                $security->getUser()->getUserIdentifier()
            )
        );

        return new JsonResponse([
            'id' => $envelope->last(HandledStamp::class)->getResult(),
        ], Response::HTTP_CREATED);
    }
}
