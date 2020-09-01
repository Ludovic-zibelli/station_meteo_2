<?php

namespace App\Repository;

use App\Entity\Arcticles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Arcticles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arcticles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arcticles[]    findAll()
 * @method Arcticles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArcticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Arcticles::class);
    }

    /**
    *@return Arcticles[]
    */
    public function findLatest(): array
    {
         return $this->createQueryBuilder('a')
             ->where('a.online = true')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Arcticles[] Returns an array of Arcticles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Arcticles
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
