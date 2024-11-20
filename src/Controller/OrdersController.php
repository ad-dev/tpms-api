<?php

namespace App\Controller;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class OrdersController extends AbstractController
{

    private OrderService $orderService;
    private SerializerInterface $serializer;

    function __construct(
        OrderService $orderService,
        SerializerInterface $serializer,
    ) {
        $this->orderService = $orderService;
        $this->serializer = $serializer;
    }

    #[Route('/orders', name: 'app_orders')]
    public function index(): JsonResponse
    {
        $fleets = $this->orderService->getActiveList();

        return New JsonResponse(
            $this->serializer->serialize($fleets, 'json'),
            200, [], true);
    }
}
