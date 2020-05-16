<?php

namespace App\Notification;

use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;

class GetStationNotification
{
    /**
     * @var false|string
     */
    private $date;

    /**
     * @var false|string
     */
    private $heure;

    private $compteur;

    /**
     *@var EntityManagerInterface
     */
    private $em;

    function __construct(EntityManagerInterface $em)
    {
        $this->date = date("d.m.Y");
        $this->heure = date("G:i");
        $this->em = $em;

    }

    /**
     * @var
     */
    private $temp1;

    /**
     * @var
     */
    private $temp2;

    private $humiditer;

    /**
     * @var
     */
    private $pression;

    /**
     * @var
     */
    private $lumiere;

    /**
     * @var
     */
    private $tension;

    /**
     * @var
     */
    private $pression_ajt;

    private $pt_rosee;

    /**
     * @var
     */
    private $pluvio;

    /**
     * @var
     */
    private $anemo;

    /**
     * @var
     */
    private $girou;

    function getStation($request)
    {
        $this->temp1 = $request->get('temp1');
        $this->temp2 = $request->get('temp2');
        $this->humiditer = $request->get('humiditer');
        $this->pression = $request->get('pression');
        $this->lumiere = $request->get('lumiere');
        $this->tension = $request->get('tempinter');
        $this->pression_ajt = $request->get('pression') + 29.68;
        $this->pt_rosee = $this->ptRosee();
        $this->pluvio = 0;
        $this->anemo = 0;
        $this->girou = 0;
        $this->compteur++;

        if($this->compteur == 60)
        {
            $this->compteur = 0;
            $this->addBdd();
        }

        $this->addBdd();
        $this->stationDirect();

    }
    //Modification du fichier station_direct.txt
    function stationDirect()
    {

        //Creation fichier TEXT
        $monfichierSD = fopen('station_direct.txt', 'w+');
        fseek($monfichierSD, 0);
        fputs($monfichierSD, $this->date. "\n");
        fputs($monfichierSD, $this->heure . "\n");
        fputs($monfichierSD, $this->temp1 ."\n");
        fputs($monfichierSD, $this->humiditer . "\n");
        fputs($monfichierSD, $this->temp2 . "\n");
        fputs($monfichierSD, $this->pression_ajt . "\n");
        fputs($monfichierSD, $this->lumiere. "\n");
        fputs($monfichierSD, $this->pluvio . "\n");
        fputs($monfichierSD, $this->anemo . "\n");
        fputs($monfichierSD, $this->girou . "\n");
        fputs($monfichierSD, $this->tension . "\n");
        fputs($monfichierSD, $this->pt_rosee . "\n");
        fclose($monfichierSD);

    }

    //Calcul du point de rosee
    function ptRosee()
    {

        $T = $this->temp2;
        $H = $this->humiditer;
        $D1 = $T;
        $D2 = $H;
        $v1 = "0.061121";
        $v2 = "17.67";
        $v3 = "243.5";
        $v4 = "440.8";
        $v5 = "19.48";
        $pt_rosee_dec =($v3*log($v1*exp($v2*$D1/($D1+$v3))*$D2)-$v4)/($v5-log($v1*exp($v2*$D1/($D1+$v3))*$D2));
        $pt_rosee = number_format($pt_rosee_dec, 2, ',','');

        return $pt_rosee;
    }

    //Modification ficher realtilegauges.txt pour les gauges
    function realTimeGauges()
    {

    }

    function addBdd()
    {
        $station = new Station();
        $station->setTemperature($this->temp2);
        $station->setHumiditer($this->humiditer);
        $station->setPression($this->pression_ajt);
        $station->setLumiere($this->lumiere);
        $station->setPointRosee($this->pt_rosee);
        $station->setGirouette($this->girou);
        $station->setAnemometre($this->anemo);
        $station->setPluviometre($this->pluvio);
        $this->em->persist($station);
        $this->em->flush();
    }
}