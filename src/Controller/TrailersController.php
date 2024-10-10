<?php

namespace App\Controller;

use App\Repository\TrailerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


class TrailersController extends AbstractController
{
    private TrailerRepository $trailerRepository;
    private $serializer;

    function __construct(
        TrailerRepository $trailerRepository,
        SerializerInterface $serializer,
    ) {
        $this->trailerRepository = $trailerRepository;
        $this->serializer = $serializer;
    }
    #[Route('/trailers', name: 'app_trailers')]
    public function index(): JsonResponse
    {
        $trailers = $this->trailerRepository->findAll();
        return New JsonResponse(
            $this->serializer->serialize($trailers, 'json'),
            200, [], true);
    }
}
