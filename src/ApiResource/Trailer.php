<?php

namespace App\ApiResource;

use App\Service\TrailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource(operations:[new GetCollection(controller:self::class)])]
class Trailer extends AbstractController
{
    private TrailerService $trailerService;
    private $serializer;

    function __construct(
        TrailerService $trailerService,
        SerializerInterface $serializer,
    ) {
        $this->trailerService = $trailerService;
        $this->serializer = $serializer;
    }

    public function index(): JsonResponse
    {
        $trailers = $this->trailerService->getAll();
        return New JsonResponse(
            $this->serializer->serialize($trailers, 'json'),
            200, [], true);
    }

    public function __invoke(): JsonResponse{
        return $this->index();
    }
}
