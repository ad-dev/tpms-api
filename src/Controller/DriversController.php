<?php

namespace App\Controller;

use App\Repository\DriverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DriversController extends AbstractController
{

    private DriverRepository $driverRepository;
    private $serializer;

    function __construct(
        DriverRepository $driverRepository,
        SerializerInterface $serializer,
    ) {
        $this->driverRepository = $driverRepository;
        $this->serializer = $serializer;
    }
    #[Route('/drivers', name: 'app_drivers')]
    public function index(): JsonResponse
    {
        $drivers = $this->driverRepository->findAll();
        return New JsonResponse(
            $this->serializer->serialize($drivers, 'json'),
            200, [], true);
    }
}
