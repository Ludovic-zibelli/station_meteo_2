<?php

namespace App\Notification;

use App\Entity\MiniMaxi;
use App\Entity\Station;
use App\Repository\MiniMaxiHRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\StationDirectRepository;
use App\Repository\StationRepository;

class BddNotification
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var MiniMaxiHRepository
     */
    private $repo;
    /**
     * @var StationDirectRepository
     */
    private $repoDirect;
     /**
     * @var StationRepository
     */
    private $stationRepo;


    /**
     * BddNotification constructor.
     * @param EntityManagerInterface $em
     * @param MiniMaxiHRepository $repo
     * @param StationDirectRepository $repoDirect
     */
    public function __construct(EntityManagerInterface $em, MiniMaxiHRepository $repo, StationDirectRepository $repoDirect, StationRepository $stationRepo)
    {

        $this->em = $em;
        $this->repo = $repo;
        $this->repoDirect = $repoDirect;
        $this->stationRepo = $stationRepo;
    }

    //Enregistrement des donnée météo en bdd
    public function AddBddStation()
    {
        $dataRepo = $this->repoDirect->findAll();
        //tranformation nombre pression a virgule en entier pour variable prevision
        if (empty($dataRepo)) {
            return; // Évite une erreur si le tableau est vide
        }
    
        // Récupération de l'entité StationMeteo associée
        $stationMeteo = $dataRepo[0]->getStationId(); 
    
        if (!$stationMeteo) {
            return; // Si la station météo est introuvable, on ne fait rien
        }
    
        // Vérifie si une entrée avec la même idStationMeteo et la même date existe déjà
        //'idStationMeteo' => $stationMeteo,  
        $existingStation = $this->em->getRepository(Station::class)->findOneBy([
            'date_heure' => $dataRepo[0]->getDateHeure() 
        ]);
    
        if ($existingStation) {
            return; // Évite d'enregistrer un doublon
        }
        
        
        $station = new Station();
        //$stationMeteo = $dataRepo[0]->getStationMeteos();
        //dd($stationMeteo);
        $station->setDateHeure($dataRepo[0]->getDateHeure());
        $station->setTemperature($dataRepo[0]->getTempbmp280());
        $station->setHumiditer($dataRepo[0]->getHumidite());
        $station->setPression($dataRepo[0]->getPression());
        $station->setLumiere($dataRepo[0]->getLumiere());
        $station->setPointRosee($dataRepo[0]->getPointRose());
        $station->setGirouette($dataRepo[0]->getGirouette());
        $station->setPluviometre($dataRepo[0]->getPluviometre());
        $station->setAnemometre($dataRepo[0]->getAnemometre());
        //dd($dataRepo[0]->getStationId());
        $station->setStationMeteos($dataRepo[0]->getStationMeteos());
        $station->setTpsvie($dataRepo[0]->getTpsvie());
        $station->setGhost($dataRepo[0]->getGhost());
        $this->em->persist($station);
        $this->em->flush();
    }

    //Sauvegarde mini maxi journaliere
    public function AddBddMiniMaxi()
    {
        //Sauvegarde en BDD avant remise a zero 
        $minimaxih = $this->repo->findByMini();

        if (empty($minimaxih)) {
            return; // Évite une erreur si $minimaxih est vide
        }

        $minimaxi = new MiniMaxi();
        $minimaxi->setMiniTemp($minimaxih[0]->getMiniTemp());
        $minimaxi->setMaxiTemp($minimaxih[0]->getMaxiTemp());
        $minimaxi->setMiniHumi($minimaxih[0]->getMiniHumi());
        $minimaxi->setMaxiHumi($minimaxih[0]->getMaxiHumi());
        $minimaxi->setMiniPres($minimaxih[0]->getMiniPres());
        $minimaxi->setMaxiPres($minimaxih[0]->getMaxiPres());
        $minimaxi->setMiniLumi($minimaxih[0]->getMiniLumi());
        $minimaxi->setMaxiLumi($minimaxih[0]->getMaxiLumi());
        $minimaxi->setMiniPtro($minimaxih[0]->getMiniPtro());
        $minimaxi->setMaxiPtro($minimaxih[0]->getMaxiPtro());
        $minimaxi->setMiniPluvio($minimaxih[0]->getMiniPluvio());
        $minimaxi->setMaxiPluvio($minimaxih[0]->getMaxiPluvio());
        $minimaxi->setMiniGirou($minimaxih[0]->getMiniGirou());
        $minimaxi->setMaxiGirou($minimaxih[0]->getMaxiGirou());
        $minimaxi->setMiniAnemo($minimaxih[0]->getMiniAnemo());
        $minimaxi->setMaxiAnemo($minimaxih[0]->getMaxiAnemo());
        $this->em->persist($minimaxi);

        //Remise des valeurs par defaut pour meuilleur correlation  
      
        $dataRepoMM = $this->repoDirect->findAll();
        $minimaxih[0]->setMiniTemp($dataRepoMM[0]->getTempbmp280());
        $minimaxih[0]->setMaxiTemp($dataRepoMM[0]->getTempbmp280());
        $minimaxih[0]->setMiniHumi($dataRepoMM[0]->getHumidite());
        $minimaxih[0]->setMaxiHumi($dataRepoMM[0]->getHumidite());
        $minimaxih[0]->setMiniPres($dataRepoMM[0]->getPression());
        $minimaxih[0]->setMaxiPres($dataRepoMM[0]->getPression());
        $minimaxih[0]->setMiniLumi($dataRepoMM[0]->getLumiere());
        $minimaxih[0]->setMaxiLumi($dataRepoMM[0]->getLumiere());
        $minimaxih[0]->setMiniPtro($dataRepoMM[0]->getPointRose());
        $minimaxih[0]->setMaxiPtro($dataRepoMM[0]->getPointRose());
        $minimaxih[0]->setMiniPluvio($dataRepoMM[0]->getPluviometre());
        $minimaxih[0]->setMaxiPluvio($dataRepoMM[0]->getPluviometre());
        $minimaxih[0]->setMiniGirou($dataRepoMM[0]->getGirouette());
        $minimaxih[0]->setMaxiGirou($dataRepoMM[0]->getGirouette());
        $minimaxih[0]->setMiniAnemo($dataRepoMM[0]->getAnemometre());
        $minimaxih[0]->setMaxiAnemo($dataRepoMM[0]->getAnemometre());
        $this->em->flush();

    }
}