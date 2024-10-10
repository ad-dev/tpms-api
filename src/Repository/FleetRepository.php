<?php

namespace App\Repository;

use App\Entity\Fleet;
use App\Model\FleetStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fleet>
 */
class FleetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fleet::class);
    }

   /**
    * @return Fleet[] Returns an array of all Fleets
    */
   public function getList(): array
   {
       return $this->createQueryBuilder('f')
           ->innerJoin('f.truck', 'trucks')
           ->innerJoin('f.trailer', 'trailers')
           ->leftJoin('f.firstDriver', 'first_driver')
           ->leftJoin('f.secondDriver', 'second_driver')
           ->addSelect('trucks', 'trailers', 'first_driver', 'second_driver')
           ->getQuery()
           ->getResult()
       ;
   }
     /**
    * @return Fleet[] Returns an array of Fleets that are in service (has at least one driver set)
    */
   public function getActiveList(): array
   {
       return $this->createQueryBuilder('f')
           ->setMaxResults(10)
           ->innerJoin('f.truck', 'trucks')
           ->innerJoin('f.trailer', 'trailers')
           ->leftJoin('f.firstDriver', 'first_driver')
           ->leftJoin('f.secondDriver', 'second_driver')
           ->where('f.firstDriver IS NOT NULL')
           ->orWhere('f.secondDriver IS NOT NULL')
           ->addSelect('trucks', 'trailers', 'first_driver', 'second_driver')
           ->getQuery()
           ->getResult();
   }
}
