<?php

namespace App\Tests;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\DataFixtures\TruckFixures;
use App\Repository\DriverRepository;
use App\Repository\FleetRepository;
use App\Repository\TruckRepository;
use Symfony\Component\Serializer\SerializerInterface;

class TrucksTest extends ApiTestCase
{

    public function testTrucks(): void
    {
        $truckRepository = static::getContainer()->get(TruckRepository::class);

        $trucks = $truckRepository->findAll();

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $trucksExpected = $serializer->serialize($trucks, 'json');

        $response = static::createClient()->request('GET', '/api/trucks');

        $this->assertResponseIsSuccessful();
        $this->assertEquals($trucksExpected, $response->getContent());
    }
}
