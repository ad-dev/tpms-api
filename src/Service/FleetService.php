<?php

namespace App\Service;

use App\Repository\FleetRepository;

class FleetService
{
    private FleetRepository $fleetRepository;

    function __construct(
        FleetRepository $fleetRepository,
    ) {
        $this->fleetRepository = $fleetRepository;
    }

    public function getList(): array
    {
        return $this->fleetRepository->getList();
    }
}
