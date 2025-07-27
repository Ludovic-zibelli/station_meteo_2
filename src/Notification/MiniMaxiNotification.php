<?php

namespace App\Notification;

use App\Entity\StationDirect;
use App\Repository\MiniMaxiHRepository;
use App\Repository\StationDirectRepository;
use Doctrine\ORM\EntityManagerInterface;


class MiniMaxiNotification
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
     * @var MeteoDirect 
     */
    private $meteoDirect;

    /**
     * MiniMaxiNotification constructor.
     * @param EntityManagerInterface $em
     * @param MiniMaxiHRepository $repo
     */
    public function __construct(EntityManagerInterface $em, MiniMaxiHRepository $repo, StationDirectRepository $meteoDirect)
    {
        $this->em = $em;
        $this->repo = $repo;
        $this->meteoDirect = $meteoDirect;
    }


    public function getMinimaxi(StationDirect $stationDirect)
    {
        // Récupère la station météo liée à cette mesure
        $stationMeteos = $stationDirect->getStationMeteos();

        // Récupère le MiniMaxiH du jour pour cette station (adapte la méthode si besoin)
        $miniMaxi = $this->repo->findOneBy([
            'stationMeteos' => $stationMeteos,
            // 'date' => new \DateTime('today'), // décommente si tu as un champ date
        ]);

        if (!$miniMaxi) {
            // Gérer le cas où il n'y a pas encore d'enregistrement pour aujourd'hui
            return;
        }

        // Récupère les valeurs directement depuis StationDirect
        $temp2      = $stationDirect->getTempdh22();
        $humiditer  = $stationDirect->getHumidite();
        $pression   = $stationDirect->getPression();
        $lumiere    = $stationDirect->getLumiere();
        $tension    = $stationDirect->getTempbmp280();
        $pression_ajt = $pression + 29.68;
        $pt_rosee   = $this->ptRoseeFromValues($temp2, $humiditer);
        $pluvio     = $stationDirect->getPluviometre();
        $anemo      = $stationDirect->getAnemometre();
        $girou      = $stationDirect->getGirouette();

        // Comparaison table journalière
        if ($temp2 < $miniMaxi->getMiniTemp()) {
            $miniMaxi->setMiniTemp($temp2);
        }
        if ($temp2 > $miniMaxi->getMaxiTemp()) {
            $miniMaxi->setMaxiTemp($temp2);
        }
        if ($humiditer < $miniMaxi->getMiniHumi()) {
            $miniMaxi->setMiniHumi($humiditer);
        }
        if ($humiditer > $miniMaxi->getMaxiHumi()) {
            $miniMaxi->setMaxiHumi($humiditer);
        }
        if ($pression_ajt < $miniMaxi->getMiniPres()) {
            $miniMaxi->setMiniPres($pression_ajt);
        }
        if ($pression_ajt > $miniMaxi->getMaxiPres()) {
            $miniMaxi->setMaxiPres($pression_ajt);
        }
        if ($lumiere < $miniMaxi->getMiniLumi()) {
            $miniMaxi->setMiniLumi($lumiere);
        }
        if ($lumiere > $miniMaxi->getMaxiLumi()) {
            $miniMaxi->setMaxiLumi($lumiere);
        }
        if ($pt_rosee < $miniMaxi->getMiniPtro()) {
            $miniMaxi->setMiniPtro($pt_rosee);
        }
        if ($pt_rosee > $miniMaxi->getMaxiPtro()) {
            $miniMaxi->setMaxiPtro($pt_rosee);
        }
        if ($anemo < $miniMaxi->getMiniAnemo()) {
            $miniMaxi->setMiniAnemo($anemo);
        }
        if ($anemo > $miniMaxi->getMaxiAnemo()) {
            $miniMaxi->setMaxiAnemo($anemo);
        }
        if ($girou < $miniMaxi->getMiniGirou()) {
            $miniMaxi->setMiniGirou($girou);
        }
        if ($girou > $miniMaxi->getMaxiGirou()) {
            $miniMaxi->setMaxiGirou($girou);
        }
        if ($pluvio < $miniMaxi->getMiniPluvio()) {
            $miniMaxi->setMiniPluvio($pluvio);
        }
        if ($pluvio > $miniMaxi->getMaxiPluvio()) {
            $miniMaxi->setMaxiPluvio($pluvio);
        }

        $this->em->flush();
    }

    // Nouvelle version de ptRosee qui prend les valeurs en paramètre
    private function ptRoseeFromValues($T, $H)
    {
        $v1 = "0.061121";
        $v2 = "17.67";
        $v3 = "243.5";
        $v4 = "440.8";
        $v5 = "19.48";
        $pt_rosee_dec = ($v3*log($v1*exp($v2*$T/($T+$v3))*$H)-$v4)/($v5-log($v1*exp($v2*$T/($T+$v3))*$H));
        return number_format($pt_rosee_dec, 2, ',','');
    }


}