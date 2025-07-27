<?php

namespace App\Repository;

use App\Entity\VigilanceMeteofrance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VigilanceMeteofrance>
 *
 * @method VigilanceMeteofrance|null find($id, $lockMode = null, $lockVersion = null)
 * @method VigilanceMeteofrance|null findOneBy(array $criteria, array $orderBy = null)
 * @method VigilanceMeteofrance[]    findAll()
 * @method VigilanceMeteofrance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VigilanceMeteofranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VigilanceMeteofrance::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(VigilanceMeteofrance $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(VigilanceMeteofrance $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

      /**
      * @return VigilanceMeteofrance[] Returns an array of MiniMaxiH objects
      */

      public function findByVigilance()
      {
          return $this->createQueryBuilder('m')
              ->orderBy('m.id', 'DESC')
              ->setMaxResults(1)
              ->getQuery()
              ->getResult()
          ;
      }


    // /**
    //  * @return VigilanceMeteofrance[] Returns an array of VigilanceMeteofrance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VigilanceMeteofrance
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
