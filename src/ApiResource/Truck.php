<?php

namespace App\ApiResource;

use App\Service\TruckService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource(operations:[new GetCollection(controller:self::class)])]
class Truck extends AbstractController
{
    private TruckService $truckService;
    private $serializer;

    function __construct(
        TruckService $truckService,
        SerializerInterface $serializer,
    ) {
        $this->truckService = $truckService;
        $this->serializer = $serializer;
    }

    public function index(): JsonResponse
    {
        $trucks = $this->truckService->getAll();
        return New JsonResponse(
            $this->serializer->serialize($trucks, 'json'),
            200, [], true);
    }

    public function __invoke(): JsonResponse{
        return $this->index();
    }
}
