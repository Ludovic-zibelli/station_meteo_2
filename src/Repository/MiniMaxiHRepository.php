<?php

namespace App\Repository;

use App\Entity\MiniMaxiH;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MiniMaxiH|null find($id, $lockMode = null, $lockVersion = null)
 * @method MiniMaxiH|null findOneBy(array $criteria, array $orderBy = null)
 * @method MiniMaxiH[]    findAll()
 * @method MiniMaxiH[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MiniMaxiHRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MiniMaxiH::class);
    }

    /**
      * @return MiniMaxiH[] Returns an array of MiniMaxiH objects
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


    /*
    public function findOneBySomeField($value): ?MiniMaxiH
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
