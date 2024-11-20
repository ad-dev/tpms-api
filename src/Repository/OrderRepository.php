<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
    * @return Fleet[] Returns an array of Fleets that are in service (has at least one driver set)
    */
    public function getActiveList(): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.fleet', 'fleets')
            ->innerJoin('fleets.truck', 'trucks')
            ->innerJoin('fleets.trailer', 'trailers')
            ->leftJoin('fleets.firstDriver', 'first_driver')
            ->leftJoin('fleets.secondDriver', 'second_driver')
            ->where('fleets.firstDriver IS NOT NULL')
            ->orWhere('fleets.secondDriver IS NOT NULL')
            ->addSelect('trucks', 'trailers', 'fleets', 'first_driver', 'second_driver')
            ->getQuery()
            ->getResult();
    }
}
