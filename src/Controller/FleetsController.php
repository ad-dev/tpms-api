<?php

namespace App\Controller;

use App\Repository\FleetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FleetsController extends AbstractController
{
    private FleetRepository $fleetRepository;
    private $serializer;

    function __construct(
        FleetRepository $fleetRepository,
        SerializerInterface $serializer,
    ) {
        $this->fleetRepository = $fleetRepository;
        $this->serializer = $serializer;
    }

    #[Route('/fleets', name: 'app_fleets')]
    public function index(): JsonResponse
    {
        $fleets = $this->fleetRepository->getList();

        return New JsonResponse(
            $this->serializer->serialize($fleets, 'json'),
            200, [], true);
    }
}
