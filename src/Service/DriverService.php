<?php

namespace App\Service;

use App\Repository\DriverRepository;

class DriverService
{

    private DriverRepository $driverRepository;

    function __construct(
        DriverRepository $driverRepository,
    ) {
        $this->driverRepository = $driverRepository;
    }

    public function getAll(): array
    {
        return $this->driverRepository->findAll();
    }
}
