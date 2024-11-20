<?php

namespace App\DataFixtures;

use App\Entity\Truck;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;
use Faker\Factory as FakerFactory;
use App\Faker\Provider\LicensePlateProvider;

class TruckFixures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = FakerFactory::create();
        $faker->addProvider(new LicensePlateProvider($faker));
        for ($i = 0; $i < 100; $i++) {

            $truck = new Truck();
            $truck->setPlateNo($faker->getTruckLicensePlate());
            $manager->persist($truck);
            $manager->flush();

        }
    }
}
