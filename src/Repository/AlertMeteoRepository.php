<?php

namespace App\Repository;

use App\Entity\AlertMeteo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AlertMeteo|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlertMeteo|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlertMeteo[]    findAll()
 * @method AlertMeteo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlertMeteoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlertMeteo::class);
    }

    /**
     * @return AlertMeteo[] Returns an array of AlertMeteo objects
     */

    public function findByAlerteAll()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()

        ;
    }

    /**
     * @return AlertMeteo[] Returns an array of AlertMeteo objects
     */

    public function findByAlerteTrue()
    {
        return $this->createQueryBuilder('a')
            ->where('a.online = true')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()

            ;
    }

    /**
     * @return AlertMeteo[] Returns an array of AlertMeteo objects
     */

    public function findByAlerteAuto()
    {
        return $this->createQueryBuilder('a')
            ->where('a.type = false')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()

            ;
    }
    /*
    public function findOneBySomeField($value): ?AlertMeteo
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
