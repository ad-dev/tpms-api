<?php

namespace App\DataFixtures;

use App\Entity\Trailer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;
use Faker\Factory as FakerFactory;

class TrailerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();
        for ($i = 0; $i < 100; $i++) {

            $truck = new Trailer();
            $truck->setPlateNo($faker->uuid());
            $manager->persist($truck);
            $manager->flush();

        }
    }
}
