<?php

namespace App\Service;

use App\Repository\TruckRepository;

class TruckService
{
    private TruckRepository $truckRepository;

    function __construct(
        TruckRepository $truckRepository,
    ) {
        $this->truckRepository = $truckRepository;
    }

    public function getAll(): array
    {
        return $this->truckRepository->findAll();
    }
}
