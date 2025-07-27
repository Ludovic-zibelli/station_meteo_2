<?php

namespace App\Repository;

use App\Entity\Recherche;
use App\Entity\Station;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Station|null find($id, $lockMode = null, $lockVersion = null)
 * @method Station|null findOneBy(array $criteria, array $orderBy = null)
 * @method Station[]    findAll()
 * @method Station[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Station::class);
    }

    // /**
    //  * @return Station[] Returns an array of Station objects
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
    /**
     * @return Station[] Returns an array of Station objects
     */
    public function findByGraph()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.id' , 'DESC')
            ->setMaxResults(48)
            ->getQuery()
            ->getResult();
    }

       /**
     * @return Station[] Returns an array of Station objects
     */
    public function findByDEC()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.id' , 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Station[] Returns an array of Station objects
     */
    public function findSearch(Recherche $recherche)
    {

        $qery = $this->createQueryBuilder('s')
         ->andWhere('s.date_heure > :dateheure')
         ->setParameter('dateheure', $recherche->getDateDebut())
         ->andWhere('s.date_heure < :datefin')
         ->setParameter('datefin', $recherche->getDateFin());

         return $qery
             ->getQuery()
             ->getResult();

    }

    public function getNb(Recherche $recherche)
    {

        return $this->createQueryBuilder('l')
            ->andWhere('l.date_heure > :dateheure')
            ->setParameter('dateheure', $recherche->getDateDebut())
            ->andWhere('l.date_heure < :datefin')
            ->setParameter('datefin', $recherche->getDateFin())
            ->select('COUNT(l.id)')
            ->getQuery()
            ->getSingleScalarResult();


    }

    
    /**
     * @param int $stationId
     * @return Station[] Returns an array of StationDirect objects filtered by station_id
     */
    public function findByStationId(int $stationId)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.stationMeteos = :stationId')
            ->setParameter('stationId', $stationId)
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(1) // Limite à un seul résultat
            ->getQuery()
            ->getOneOrNullResult(); // Retourne un seul résultat ou null
            
        ;
    }

    /**
     * @param int $stationId
     * @return Station[] Returns an array of Station objects for the given station ID
     */
    public function findByGraphForStation(int $stationId)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.stationMeteos = :stationId')
            ->setParameter('stationId', $stationId)
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(48)
            ->getQuery()
            ->getResult();
    }
    /*
    public function findOneBySomeField($value): ?Station
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
