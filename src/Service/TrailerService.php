<?php

namespace App\Service;

use App\Repository\TrailerRepository;

class TrailerService
{
    private TrailerRepository $trailerRepository;

    function __construct(
        TrailerRepository $trailerRepository,
    ) {
        $this->trailerRepository = $trailerRepository;
    }

    public function getAll(): array
    {
        return $this->trailerRepository->findAll();
    }
}
