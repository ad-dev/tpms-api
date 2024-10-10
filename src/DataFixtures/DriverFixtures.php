<?php

namespace App\DataFixtures;

use App\Entity\Driver;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

class DriverFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        $faker = FakerFactory::create();
        for ($i = 0; $i < 100; $i++) {

            $driver = new Driver();
            $driver->setName($faker->name());
            $driver->setLastName($faker->lastName());
            $manager->persist($driver);
            $manager->flush();
        }
    }
}
