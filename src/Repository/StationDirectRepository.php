<?php

namespace App\Repository;

use App\Entity\StationDirect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StationDirect|null find($id, $lockMode = null, $lockVersion = null)
 * @method StationDirect|null findOneBy(array $criteria, array $orderBy = null)
 * @method StationDirect[]    findAll()
 * @method StationDirect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StationDirectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StationDirect::class);
    }

        /**
      * @return StationDirect[] Returns an array of MiniMaxiH objects
      */

      public function findByMini()
      {
          return $this->createQueryBuilder('m')
              ->orderBy('m.id', 'DESC')
              ->setMaxResults(1)
              ->getQuery()
              ->getResult()
          ;
      }
  
    // /**
    //  * @return StationDirect[] Returns an array of StationDirect objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StationDirect
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
