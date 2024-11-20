<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Enum\FleetStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Fleet;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    private $managerRegistry;
    private $entityManager;

    public function __construct(ManagerRegistry $managerRegistry,  EntityManagerInterface $entityManager) {
        $this->managerRegistry = $managerRegistry;
        $this->entityManager = $entityManager;

    }
    public function load(ObjectManager $manager): void
    {
        $fleetRepository = $manager->getRepository(Fleet::class);
        $orderRepository = $manager->getRepository(Order::class);

        $cout = new ConsoleOutput();
        $orderTable = new Table($cout);

        $maxOrders = 20; // orders to create. In the end it could be less because of possible constraint volations

        $fleetsTotal = $fleetRepository->getTotalCount();

        for ($i = 0; $i < $maxOrders; $i++) {

            $randomFleetNo = mt_rand(0, $fleetsTotal-1);
            $list = $fleetRepository->findBy([], null, 1, $randomFleetNo);
            if (empty($list)) {
                continue;
            }
            $order = new Order();
            $order->setFleet(current($list));
            $order->setCreatedAt((new \DateTimeImmutable()));

            $this->entityManager->beginTransaction();

            try {
                $this->entityManager->persist($order);
                $this->entityManager->flush();
                $this->entityManager->commit();

                $firstDriver = $order->getFleet()->getFirstDriver();
                $secondDriver = $order->getFleet()->getSecondDriver();

                $orderTable->addRow(
                    [
                        $order->getId(),
                        $order->getCreatedAt()->format("Y-m-d H:i:s"),
                        $order->getIsCompleted() === true ? "yes" : "no",
                        $order->getFleet()->getId(),
                        $order->getFleet()->getTruck()->getPlateNo(),
                        $order->getFleet()->getTrailer()->getPlateNo(),
                        isset($firstDriver) ? $firstDriver->getFullName() : "N/A",
                        isset($secondDriver) ? $secondDriver->getFullName() : "N/A",
                        $order->getFleet()->getStatus()->name,
                    ],
                );

            } catch (\Exception $e) { // if record insert fails due to unique constraint volation, reset EntityManager to be able continue with next insertions
                $this->managerRegistry->resetManager();
                $this->entityManager->flush();
                $this->entityManager->commit();
            }

        }

        $orderTable->setHeaders(['Order #', 'created At','Is completed', 'fleet #', 'Truck','Trailer', 'First driver','Second driver', 'fleet status']);
        $orderTable->render();

    }

    public function getDependencies(): array
    {
        return [
            FleetFixtures::class,
        ];
    }
}
