<?php

namespace App\Service;

use App\Repository\FleetRepository;

class OrderService
{
    private FleetRepository $fleetRepository;

    function __construct(
        FleetRepository $fleetRepository,
    ) {
        $this->fleetRepository = $fleetRepository;
    }

    public function getActiveList(): array
    {
        return $this->fleetRepository->getActiveList();
    }
}
