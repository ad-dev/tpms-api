<?php

namespace App\ApiResource;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource(operations:[new GetCollection(controller:self::class)])]
class Order extends AbstractController
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

        public function index(): JsonResponse
    {
        $fleets = $this->orderService->getActiveList();

        return New JsonResponse(
            $this->serializer->serialize($fleets, 'json'),
            200, [], true);
    }

    public function __invoke(): JsonResponse{
        return $this->index();
    }

}
