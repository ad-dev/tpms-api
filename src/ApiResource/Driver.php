<?php

namespace App\ApiResource;

use App\Service\DriverService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource(operations:[new GetCollection(controller:Driver::class)])]
class Driver extends AbstractController
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
    public function index(): JsonResponse
    {
        $drivers = $this->driverService->getAll();
        return New JsonResponse(
            $this->serializer->serialize($drivers, 'json'),
            200, [], true);
    }

    function __invoke(): JsonResponse{
        return $this->index();
    }
}
