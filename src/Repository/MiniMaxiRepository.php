<?php

namespace App\Repository;

use App\Entity\MiniMaxi;
use App\Entity\MinimaxiSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MiniMaxi|null find($id, $lockMode = null, $lockVersion = null)
 * @method MiniMaxi|null findOneBy(array $criteria, array $orderBy = null)
 * @method MiniMaxi[]    findAll()
 * @method MiniMaxi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MiniMaxiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MiniMaxi::class);
    }

    /**
     * @return MiniMaxi[]
     */
    public function findMiniMax()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return MiniMaxi[]
     */
    public function findAllMiniMaxiDesc(MinimaxiSearch $search)
    {
        $query = $this->createQueryBuilder('m');

        if($search->getDate())
        {

            $query = $query
                ->andWhere('m.creatd_at > :date ')
                ->setParameter('date', $search->getDate())
                ->andWhere('m.creatd_at < :date_end ')
                ->setParameter('date_end', $search->getDateInterval());
        }
        else
        {
            $query = $query
                ->orderBy('m.id', 'DESC');

        }

        return $query
            ->getQuery()
            ->getResult();


    }

    /**
     * @return MiniMaxi[]
     */
    public function findMiniMaxQuery()
    {
        return $this->findAllMiniMaxiDesc()
            ->getQuery();

    }
    // /**
    //  * @return MiniMaxi[] Returns an array of MiniMaxi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MiniMaxi
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
