<?php

namespace App\Controller;

use App\Service\TrailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


class TrailersController extends AbstractController
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
    #[Route('/trailers', name: 'app_trailers')]
    public function index(): JsonResponse
    {
        $trailers = $this->trailerService->getAll();
        return New JsonResponse(
            $this->serializer->serialize($trailers, 'json'),
            200, [], true);
    }
}
