<?php

namespace App\Controller;

use App\Service\DriverService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DriversController extends AbstractController
{

    private DriverService $driverService;
    private $serializer;

    function __construct(
        DriverService $driverService,
        SerializerInterface $serializer,
    ) {
        $this->driverService = $driverService;
        $this->serializer = $serializer;
    }
    #[Route('/drivers', name: 'app_drivers')]
    public function index(): JsonResponse
    {
        $drivers = $this->driverService->getAll();
        return New JsonResponse(
            $this->serializer->serialize($drivers, 'json'),
            200, [], true);
    }
}
