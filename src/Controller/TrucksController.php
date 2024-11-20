<?php

namespace App\Controller;

use App\Entity\FleetStatus;
use App\Model\FleetStatusEnum;
use App\Service\TruckService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


class TrucksController extends AbstractController
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
    #[Route('/trucks', name: 'app_trucks')]
    public function index(): JsonResponse
    {
        $trucks = $this->truckService->getAll();
        return New JsonResponse(
            $this->serializer->serialize($trucks, 'json'),
            200, [], true);
    }
}
