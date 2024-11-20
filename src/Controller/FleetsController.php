<?php

namespace App\Controller;

use App\Service\FleetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FleetsController extends AbstractController
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

    #[Route('/fleets', name: 'app_fleets')]
    public function index(): JsonResponse
    {
        $fleets = $this->fleetService->getList();

        return New JsonResponse(
            $this->serializer->serialize($fleets, 'json'),
            200, [], true);
    }
}
