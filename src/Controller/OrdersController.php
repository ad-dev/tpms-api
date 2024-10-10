<?php

namespace App\Controller;

use App\Repository\FleetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class OrdersController extends AbstractController
{

    private FleetRepository $fleetRepository;
    private SerializerInterface $serializer;

    function __construct(
        FleetRepository $fleetRepository,
        SerializerInterface $serializer,
    ) {
        $this->fleetRepository = $fleetRepository;
        $this->serializer = $serializer;
    }

    #[Route('/orders', name: 'app_orders')]
    public function index(): JsonResponse
    {
        $fleets = $this->fleetRepository->getActiveList();

        return New JsonResponse(
            $this->serializer->serialize($fleets, 'json'),
            200, [], true);
    }
}
