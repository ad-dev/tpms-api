<?php

namespace App\Repository;

use App\Entity\Trailer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trailer>
 */
class TrailerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trailer::class);
    }


    public function geTotalCount(): int
    {
        return $this->createQueryBuilder('t')->select('COUNT(1)')->getQuery()->getSingleScalarResult();

    }
}
