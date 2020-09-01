<?php

namespace App\Notification;

use App\Entity\MiniMaxi;
use App\Entity\Station;
use App\Repository\MiniMaxiHRepository;
use Doctrine\ORM\EntityManagerInterface;

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
     * BddNotification constructor.
     * @param EntityManagerInterface $em
     * @param MiniMaxiHRepository $repo
     */
    public function __construct(EntityManagerInterface $em, MiniMaxiHRepository $repo)
    {

        $this->em = $em;
        $this->repo = $repo;
    }

    //Enregistrement des donnée météo en bdd
    public function AddBddStation()
    {
        //Lecture d'un fichier .txt ligne par ligne et stokage dans un tableau
        # Chemin vers fichier texte
        $file ="public/station_direct.txt";
        # On met dans la variable (tableau $read) le contenu du fichier
        $read=file($file);
        //tranformation nombre pression a virgule en entier pour variable prevision
        $station = new Station();
        $station->setTemperature((float)$read[4]);
        $station->setHumiditer((int)$read[3]);
        $station->setPression((float)$read[5]);
        $station->setLumiere((int)$read[6]);
        $station->setPointRosee((float)$read[11]);
        $station->setGirouette((int)0);
        $station->setPluviometre((int)0);
        $station->setAnemometre((int)0);
        $this->em->persist($station);
        $this->em->flush();
    }

    //Sauvegarde mini maxi journaliere
    public function AddBddMiniMaxi()
    {

        $minimaxih = $this->repo->findByMini();
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
        //Lecture d'un fichier .txt ligne par ligne et stokage dans un tableau
        # Chemin vers fichier texte
        $file ="public/station_direct.txt";
        # On met dans la variable (tableau $read) le contenu du fichier
        $read=file($file);
        $minimaxih[0]->setMiniTemp((float)$read[4]);
        $minimaxih[0]->setMaxiTemp((float)$read[4]);
        $minimaxih[0]->setMiniHumi((int)$read[3]);
        $minimaxih[0]->setMaxiHumi((int)$read[3]);
        $minimaxih[0]->setMiniPres((float)$read[5]);
        $minimaxih[0]->setMaxiPres((float)$read[5]);
        $minimaxih[0]->setMiniLumi((int)$read[6]);
        $minimaxih[0]->setMaxiLumi((int)$read[6]);
        $minimaxih[0]->setMiniPtro((float)$read[11]);
        $minimaxih[0]->setMaxiPtro((float)$read[11]);
        $minimaxih[0]->setMiniPluvio((int)0);
        $minimaxih[0]->setMaxiPluvio((int)0);
        $minimaxih[0]->setMiniGirou((int)0);
        $minimaxih[0]->setMaxiGirou((int)0);
        $minimaxih[0]->setMiniAnemo((int)0);
        $minimaxih[0]->setMaxiAnemo((int)0);
        $this->em->flush();

    }
}