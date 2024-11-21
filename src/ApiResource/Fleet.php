<?php

namespace App\ApiResource;

use App\Service\FleetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource(operations:[new GetCollection(controller:self::class)])]
class Fleet extends AbstractController
{
    private FleetService $fleetService;
    private $serializer;

    function __construct(
        FleetService $fleetService,
        SerializerInterface $serializer,
    ) {
        $this->fleetService = $fleetService;
        $this->serializer = $serializer;
    }


    public function index(): JsonResponse
    {
        $fleets = $this->fleetService->getList();

        return New JsonResponse(
            $this->serializer->serialize($fleets, 'json'),
            200, [], true);
    }
    function __invoke(): JsonResponse{
        return $this->index();
    }

}
