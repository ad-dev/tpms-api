<?php

namespace App\Tests;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\DriverRepository;
use Symfony\Component\Serializer\SerializerInterface;

class DriversTest extends ApiTestCase
{

    public function testDrivers(): void
    {
        $driverRepository = static::getContainer()->get(DriverRepository::class);

        $drivers = $driverRepository->findAll();

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $driversExpected = $serializer->serialize($drivers, 'json');

        $response = static::createClient()->request('GET', '/api/drivers');

        $this->assertResponseIsSuccessful();
        $this->assertEquals($driversExpected, $response->getContent());
    }
}
