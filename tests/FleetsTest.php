<?php

namespace App\Tests;
use App\Entity\Driver;
use App\Entity\Fleet;
use App\Entity\Trailer;
use App\Entity\Truck;
use App\Model\FleetStatusEnum;
use App\Repository\FleetRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

class FleetsTest extends KernelTestCase
{
    private Container $container;

    private managerRegistry $managerRegistry;

    private EntityManagerInterface $entityManager;

    public function setUp(): void{
        parent::setUp();
        $this->container = static::getContainer();
        $this->entityManager = $this->container->get(EntityManagerInterface::class);
        $this->managerRegistry = $this->container->get(ManagerRegistry::class);
        $this->wipeDB();
    }

    private function wipeDB():void {

        $conn = $this->managerRegistry->getConnection($this->managerRegistry->getDefaultConnectionName());
        $conn->exec("DELETE FROM fleet");
        $conn->exec("DELETE FROM driver");
        $conn->exec("DELETE FROM truck");
    }

    public function tesFleetWithOneDriver(): void
    {
        $fleetRepository = static::getContainer()->get(FleetRepository::class);

        $truck = new Truck();
        $truck->setPlateNo('ABC123');
        $this->entityManager->persist($truck);

        $trailer = new Trailer();
        $trailer->setPlateNo('T1234');
        $this->entityManager->persist($trailer);

        $driver = new Driver();
        $driver->setName("John")->setLastName("Doe");
        $this->entityManager->persist($driver);

        $fleet = new Fleet();
        $fleet->setFirstDriver($driver);
        $fleet->setTruck($truck);
        $fleet->setTrailer($trailer);
        $this->entityManager->persist($fleet);
        $this->entityManager->flush();

        $fleets = $fleetRepository->findAll();
        $fleet = reset($fleets);

        $this->assertEquals('John', $fleet->getFirstDriver()->getName());
        $this->assertEquals('Doe', $fleet->getFirstDriver()->getLastName());
        $this->assertEquals('ABC123', $fleet->getTruck()->getPlateNo());
        $this->assertEquals('T1234', $fleet->getTrailer()->getPlateNo());

    }

    public function testFleetWithTwoDrivers(): void
    {
        $fleetRepository = static::getContainer()->get(FleetRepository::class);

        $truck = new Truck();
        $truck->setPlateNo('ABC123');
        $this->entityManager->persist($truck);

        $trailer = new Trailer();
        $trailer->setPlateNo('T1234');
        $this->entityManager->persist($trailer);


        $driver1 = new Driver();
        $driver1->setName("John")->setLastName("Doe");
        $this->entityManager->persist($driver1);

        $driver2 = new Driver();
        $driver2->setName("Backup")->setLastName("Driver");
        $this->entityManager->persist($driver2);

        $fleet = new Fleet();
        $fleet->setFirstDriver($driver1);
        $fleet->setSecondDriver($driver2);

        $fleet->setTruck($truck);
        $fleet->setTrailer($trailer);
        $fleet->setStatus(FleetStatusEnum::Works);
        $this->entityManager->persist($fleet);
        $this->entityManager->flush();
        $fleets = $fleetRepository->findAll();

        $fleetActual = reset($fleets);

        $this->assertEquals($fleetActual->getStatus(), $fleet->getStatus());
        $this->assertEquals('John', $fleet->getFirstDriver()->getName());
        $this->assertEquals('Doe', $fleet->getFirstDriver()->getLastName());
        $this->assertEquals('Backup', $fleet->getSecondDriver()->getName());
        $this->assertEquals('ABC123', $fleet->getTruck()->getPlateNo());
        $this->assertEquals('T1234', $fleet->getTrailer()->getPlateNo());

    }

    public function testEmptyFleet(): void
    {

        $fleetRepository = static::getContainer()->get(FleetRepository::class);
        $fleet = new Fleet();

        $this->entityManager->persist($fleet);
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
        }
        $fleets = $fleetRepository->findAll();

        $this->assertCount(0, $fleets);
    }
}
