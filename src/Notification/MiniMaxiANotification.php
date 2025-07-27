<?php
namespace App\Notification;

use App\Repository\MiniMaxiARepository;
use App\Repository\MiniMaxiHRepository;
use Doctrine\ORM\EntityManagerInterface;

class MiniMaxiANotification
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var MiniMaxiARepository
     */
    private $mna;
    /**
     * @var MiniMaxiHRepository
     */
    private $mnh;

    

    /**
     * @var \DateTime
     */
    private $date_time;

    public function __construct(EntityManagerInterface $em, MiniMaxiARepository $mna, MiniMaxiHRepository $mnh)
    {
        $this->em = $em;
        $this->mna = $mna;
        $this->mnh = $mnh;
        $this->date_time = new \DateTime();
    }

    public function minimaxicompare($stationMeteos)
    {
        // Récupère les valeurs horaires et agrégées pour la station donnée
        $bdd = $this->mnh->findByMiniForStation($stationMeteos);
        $bdd2 = $this->mna->findByMiniForStation($stationMeteos);

        if (!$bdd || !$bdd2 || !isset($bdd[0]) || !isset($bdd2[0])) {
            // Gérer le cas où il n'y a pas de données pour cette station
            return;
        }

        // On travaille sur les premiers résultats (le plus récent du jour)
        $h = $bdd[0];
        $a = $bdd2[0];

        if ($h->getMiniTemp() < $a->getMiniTemp()) {
            $a->setMiniTemp($h->getMiniTemp());
            $a->setDateMiniTemp($this->date_time);
        }
        if ($h->getMaxiTemp() > $a->getMaxiTemp()) {
            $a->setMaxiTemp($h->getMaxiTemp());
            $a->setDateMaxiTemp($this->date_time);
        }
        if ($h->getMiniHumi() < $a->getMiniHumi()) {
            $a->setMiniHumi($h->getMiniHumi());
            $a->setDateMiniHumi($this->date_time);
        }
        if ($h->getMaxiHumi() > $a->getMaxiHumi()) {
            $a->setMaxiHumi($h->getMaxiHumi());
            $a->setDateMaxiHumi($this->date_time);
        }
        if ($h->getMiniPres() < $a->getMiniPres()) {
            $a->setMiniPres($h->getMiniPres());
            $a->setDateMiniPres($this->date_time);
        }
        if ($h->getMaxiPres() > $a->getMaxiPres()) {
            $a->setMaxiPres($h->getMaxiPres());
            $a->setDateMaxiPres($this->date_time);
        }
        if ($h->getMiniLumi() < $a->getMiniLumi()) {
            $a->setMiniLumi($h->getMiniLumi());
            $a->setDateMiniLumi($this->date_time);
        }
        if ($h->getMaxiLumi() > $a->getMaxiLumi()) {
            $a->setMaxiLumi($h->getMaxiLumi());
            $a->setDateMaxiLumi($this->date_time);
        }
        if ($h->getMiniPtro() < $a->getMiniPtro()) {
            $a->setMiniPtro($h->getMiniPtro());
            $a->setDateMiniPtro($this->date_time);
        }
        if ($h->getMaxiPtro() > $a->getMaxiPtro()) {
            $a->setMaxiPtro($h->getMaxiPtro());
            $a->setDateMaxiPtro($this->date_time);
        }
        if ($h->getMiniAnemo() < $a->getMiniAnemo()) {
            $a->setMiniAnemo($h->getMiniAnemo());
            $a->setDateMiniAnemo($this->date_time);
        }
        if ($h->getMaxiAnemo() > $a->getMaxiAnemo()) {
            $a->setMaxiAnemo($h->getMaxiAnemo());
            $a->setDateMaxiAnemo($this->date_time);
        }
        if ($h->getMiniGirou() < $a->getMiniGirou()) {
            $a->setMiniGirou($h->getMiniGirou());
            $a->setDateMiniGirou($this->date_time);
        }
        if ($h->getMaxiGirou() > $a->getMaxiGirou()) {
            $a->setMaxiGirou($h->getMaxiGirou());
            $a->setDateMaxiGirou($this->date_time);
        }
        if ($h->getMiniPluvio() < $a->getMiniPluvio()) {
            $a->setMiniPluvio($h->getMiniPluvio());
            $a->setDateMiniPluvio($this->date_time);
        }
        if ($h->getMaxiPluvio() > $a->getMaxiPluvio()) {
            $a->setMaxiPluvio($h->getMaxiPluvio());
            $a->setDateMaxiPluvio($this->date_time);
        }

        $this->em->flush();
    }
    
}