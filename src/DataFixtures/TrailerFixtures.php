<?php

namespace App\DataFixtures;

use App\Entity\Trailer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;
use Faker\Factory as FakerFactory;
use App\Faker\Provider\LicensePlateProvider;

class TrailerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();
        $faker->addProvider(new LicensePlateProvider($faker));
        for ($i = 0; $i < 100; $i++) {

            $truck = new Trailer();
            $truck->setPlateNo($faker->getTrailerLicensePlate());
            $manager->persist($truck);
            $manager->flush();

        }
    }
}
