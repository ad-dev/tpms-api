<?php

namespace App\Tests;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\DataFixtures\TruckFixures;
use App\Repository\OrderRepository;
use Symfony\Component\Serializer\SerializerInterface;

class OrdersTest extends ApiTestCase
{

    public function testOrdersList(): void
    {
        $orderRepository = static::getContainer()->get(OrderRepository::class);

        $fleets = $orderRepository->getActiveList();

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $fleetsExpected = $serializer->serialize($fleets, 'json');

        $response = static::createClient()->request('GET', '/api/orders');

        $this->assertResponseIsSuccessful();
        $this->assertEquals($fleetsExpected, $response->getContent());
    }
}
