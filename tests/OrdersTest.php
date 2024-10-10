<?php

namespace App\Tests;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\DataFixtures\TruckFixures;
use App\Repository\FleetRepository;
use Symfony\Component\Serializer\SerializerInterface;



class OrdersTest extends ApiTestCase
{

    public function testOrdersList(): void
    {
        $fleetRepository = static::getContainer()->get(FleetRepository::class);

        $fleets = $fleetRepository->getActiveList();

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $fleetsExpected = $serializer->serialize($fleets, 'json');

        $response = static::createClient()->request('GET', '/orders');

        $this->assertResponseIsSuccessful();
        $this->assertEquals($fleetsExpected, $response->getContent());
    }
}
