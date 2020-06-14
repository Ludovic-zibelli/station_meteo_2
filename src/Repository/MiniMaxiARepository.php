<?php

namespace App\Repository;

use App\Entity\MiniMaxiA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MiniMaxiA|null find($id, $lockMode = null, $lockVersion = null)
 * @method MiniMaxiA|null findOneBy(array $criteria, array $orderBy = null)
 * @method MiniMaxiA[]    findAll()
 * @method MiniMaxiA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MiniMaxiARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MiniMaxiA::class);
    }

    /**
     * @return MiniMaxiA[] Returns an array of MiniMaxiA objects
     */

    public function findByMiniA()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?MiniMaxiA
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
