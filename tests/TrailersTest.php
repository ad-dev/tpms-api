<?php

namespace App\Tests;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\DataFixtures\TruckFixures;
use App\Repository\DriverRepository;
use App\Repository\FleetRepository;
use App\Repository\TrailerRepository;
use App\Repository\TruckRepository;
use Symfony\Component\Serializer\SerializerInterface;

class TrailersTest extends ApiTestCase
{

    public function testTrailers(): void
    {
        $trailerRepository = static::getContainer()->get(TrailerRepository::class);

        $trailers = $trailerRepository->findAll();

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $trailersExpected = $serializer->serialize($trailers, 'json');

        $response = static::createClient()->request('GET', '/trailers');

        $this->assertResponseIsSuccessful();
        $this->assertEquals($trailersExpected, $response->getContent());
    }
}
