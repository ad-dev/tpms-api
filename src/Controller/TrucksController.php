<?php

namespace App\Controller;

use App\Entity\FleetStatus;
use App\Model\FleetStatusEnum;
use App\Repository\TruckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


class TrucksController extends AbstractController
{
    private TruckRepository $truckRepository;
    private $serializer;

    function __construct(
        TruckRepository $truckRepository,
        SerializerInterface $serializer,
    ) {
        $this->truckRepository = $truckRepository;
        $this->serializer = $serializer;
    }
    #[Route('/trucks', name: 'app_trucks')]
    public function index(): JsonResponse
    {
        $trucks = $this->truckRepository->findAll();
        return New JsonResponse(
            $this->serializer->serialize($trucks, 'json'),
            200, [], true);
    }
}
