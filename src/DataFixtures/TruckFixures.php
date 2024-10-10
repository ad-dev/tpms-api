<?php

namespace App\DataFixtures;

use App\Entity\Truck;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;
use Faker\Factory as FakerFactory;

class TruckFixures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = FakerFactory::create();
        for ($i = 0; $i < 100; $i++) {

            $truck = new Truck();
            $truck->setPlateNo($faker->uuid());
            $manager->persist($truck);
            $manager->flush();

        }
    }
}
