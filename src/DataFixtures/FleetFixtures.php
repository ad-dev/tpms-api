<?php

namespace App\DataFixtures;
use App\Entity\Driver;
use App\Entity\Trailer;
use App\Entity\Truck;
use App\Model\FleetStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Fleet;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class FleetFixtures extends Fixture implements DependentFixtureInterface
{
    private $managerRegistry;
    private $entityManager;

    public function __construct(ManagerRegistry $managerRegistry,  EntityManagerInterface $entityManager) {
        $this->managerRegistry = $managerRegistry;
        $this->entityManager = $entityManager;

    }
    public function load(ObjectManager $manager): void
    {

        $cout = new ConsoleOutput();
        $fleetsTable = new Table($cout);

        $maxRandomNumber = 200; // set higher number to increase change to avoid second driver to be set

        $statuses = FleetStatusEnum::cases();

        $driverRepository = $manager->getRepository(Driver::class);
        $truckRepository = $manager->getRepository(Truck::class);
        $trailerRepository = $manager->getRepository(Trailer::class);

        $driversTotal = $driverRepository->geTotalCount();

        for($i = 0; $i < $driversTotal; $i++) {
            $firstDriver = null;
            $randomDriverNo = mt_rand(0, $maxRandomNumber);

            $list = $driverRepository->findBy([], null, 1, $randomDriverNo);
            if (!empty($list)) {
                $firstDriver = reset($list);
            }

            $secondDriver =  null;
            $randomDriverNo = mt_rand(0, $maxRandomNumber);
            $list = $driverRepository->findBy([], null, 1, $randomDriverNo);
            if (!empty($list)) {
                $secondDriver = current($list);
            }

            $truck = null;
            $trailer = null;
            $randomTruckNo = mt_rand(0, $maxRandomNumber);
            $randomTrailerNo = mt_rand(0, $maxRandomNumber);

            $fleet = new Fleet();

            $list = $truckRepository->findBy([], null, 1, $randomTruckNo);
            if (!empty($list)) {
                $truck = reset($list);
                $fleet->setTruck($truck);
            }

            $list = $trailerRepository->findBy([], null, 1, $randomTrailerNo);
            if (!empty($list)) {
                $trailer = reset($list);
                $fleet->setTrailer($trailer);

            }

            if (!isset($truck) || !isset($trailer)) {
                continue;
            }

            if (isset($firstDriver)) {
                $fleet->setFirstDriver( $firstDriver);
            }

            if (isset($firstDriver) && isset($secondDriver) ) {
                $fleet->setSecondDriver( $secondDriver);
            }
            $randomStatus = $statuses[mt_rand(1,count($statuses) - 1)];

            if (isset($firstDriver) || isset($secondDriver)) {
                $fleet->setStatus($randomStatus);
            } else {
                $randomStatus = FleetStatusEnum::Free;
                $fleet->setStatus($randomStatus);
            }

            $fleetsTable->addRow(
                [
                    isset($truck) ? $truck->getPlateNo() :"null",
                    isset($trailer) ? $trailer->getPlateNo() :"null",
                    isset($firstDriver) ? $firstDriver->getName() :"null",
                    isset($secondDriver) ? $secondDriver->getLastName() :"null",
                    $randomStatus->name,
                ]
            );

            $this->entityManager->beginTransaction();

            try {
                $this->entityManager->persist($fleet);
                $this->entityManager->flush();
                $this->entityManager->commit();

            } catch (\Exception $e) { // if record insert fails due to unique constrains volation, reset EntityManager to be able continue with next insertions
                $this->managerRegistry->resetManager();
                $this->entityManager->flush();
                $this->entityManager->commit();
            }
        }
        $fleetsTable->setHeaders(['Truck','Trailer', 'First driver','Second driver', 'status']);
        $fleetsTable->render();

        $statusDescriptonTable = new Table($cout);
        $statusDescriptonTable->setHeaderTitle('available statuses');
        $statusDescriptonTable->setHeaders(['status','description']);
        foreach($statuses as $status) {
            $statusDescriptonTable->addRow([sprintf('<comment>%s</comment>', $status->name), $status->getDescription()]);
        }
        $statusDescriptonTable->render();
        $cout->writeln('');
    }

    public function getDependencies(): array
    {
        return [
            DriverFixtures::class,
            TruckFixures::class,
            TrailerFixtures::class,
        ];
    }
}
