<?php

namespace App\Service;

use App\Repository\OrderRepository;

class OrderService
{
    private OrderRepository $orderRepository;

    function __construct(
        OrderRepository $orderRepository,
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function getActiveList(): array
    {
        return $this->orderRepository->getActiveList();
    }
}
