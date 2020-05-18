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

    /**
     * @var
     */
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

    /**
     * @var
     */
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

    /**
     * @var
     */
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

    /**
     * @var
     */
    private $mini_temp = 0;

    /**
     * @var
     */
    private $maxi_temp = 0;

    /**
     * @var
     */
    private $mini_humi = 0;

    /**
     * @var
     */
    private $maxi_humi = 0;

    /**
     * @var
     */
    private $mini_pres = 0;

    /**
     * @var
     */
    private $maxi_pres = 0;

    /**
     * @var
     */
    private $mini_lumi = 0;

    /**
     * @var
     */
    private $maxi_lumi = 0;

    /**
     * @var
     */
    private $mini_ptro = 0;

    /**
     * @var
     */
    private $maxi_ptro = 0;

    /**
     * @var
     */
    private $mini_anemo = 0;

    /**
     * @var
     */
    private $maxi_anemo = 0;

    /**
     * @var
     */
    private $mini_girou = 0;

    /**
     * @var
     */
    private $maxi_girou = 0;

    /**
     * @var
     */
    private $mini_pluvio = 0;

    /**
     * @var
     */
    private $maxi_pluvio = 0;

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

        //$this->addBdd();
        //$this->miniMaxi();
        $this->realTimeGauges();
        $this->stationDirect();
        $this->fichierMn();






    }
    //Modification du fichier station_direct.txt
    function stationDirect()
    {

        //Creation fichier TEXT
        $monfichierSD = fopen('station_direct.txt', 'w+');
        fseek($monfichierSD, 0);
        fputs($monfichierSD, $this->date . "\n");
        fputs($monfichierSD, $this->heure . "\n");
        fputs($monfichierSD, $this->temp1 . "\n");
        fputs($monfichierSD, $this->humiditer . "\n");
        fputs($monfichierSD, $this->temp2 . "\n");
        fputs($monfichierSD, $this->pression_ajt . "\n");
        fputs($monfichierSD, $this->lumiere . "\n");
        fputs($monfichierSD, $this->pluvio . "\n");
        fputs($monfichierSD, $this->anemo . "\n");
        fputs($monfichierSD, $this->girou . "\n");
        fputs($monfichierSD, $this->tension . "\n");
        fputs($monfichierSD, $this->pt_rosee . "\n");
        fclose($monfichierSD);


    }

    function fichierMn()
    {
        $monfichierMn = fopen('minimaxi.txt', 'w+');
        fseek($monfichierMn, 0);
        fputs($monfichierMn, $this->mini_temp . "\n");
        fputs($monfichierMn, $this->maxi_temp . "\n");
        fputs($monfichierMn, $this->mini_humi . "\n");
        fputs($monfichierMn, $this->maxi_humi . "\n");
        fputs($monfichierMn, $this->mini_pres . "\n");
        fputs($monfichierMn, $this->maxi_pres . "\n");
        fputs($monfichierMn, $this->mini_lumi . "\n");
        fputs($monfichierMn, $this->maxi_lumi . "\n");
        fputs($monfichierMn, $this->mini_ptro . "\n");
        fputs($monfichierMn, $this->maxi_ptro . "\n");
        fputs($monfichierMn, $this->mini_anemo . "\n");
        fputs($monfichierMn, $this->maxi_anemo . "\n");
        fputs($monfichierMn, $this->mini_girou . "\n");
        fputs($monfichierMn, $this->maxi_girou . "\n");
        fputs($monfichierMn, $this->mini_pluvio . "\n");
        fputs($monfichierMn, $this->maxi_pluvio . "\n");
        fclose($monfichierMn);
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
        $gauges = fopen('realtimegauges.txt' ,'w+');
        fseek($gauges, 0);
        fputs($gauges, '{"date":"'. $this->heure . '",'. "\n" );
        fputs($gauges, '"temp":"'.$this->temp2.'",' . "\n" );//Temperature
        fputs($gauges, '"tempTL":"'. $this->mini_temp .'",'."\n");//Temperature Mini
        fputs($gauges, '"tempTH":"'. $this->maxi_temp .'",'. "\n" );//Temperature maxi
        fputs($gauges, '"intemp":"'.$this->temp1.'",' . "\n" );//Temperature interieur
        fputs($gauges, '"dew":"'.$this->pt_rosee.'",' . "\n" );//Point de rosee
        fputs($gauges, '"dewpointTL":"'.$this->mini_ptro .'",' . "\n");//Point de rosee mini
        fputs($gauges, '"dewpointTH":"'.$this->maxi_ptro .'",' . "\n");//Poinrt de rosee maxi
        fputs($gauges, '"apptemp":"'.$this->mini_ptro .'",' . "\n");
        fputs($gauges, '"apptempTL":"'.$this->mini_ptro .'",' . "\n");
        fputs($gauges, '"apptempTH":"'.$this->mini_ptro .'",' . "\n");
        fputs($gauges, '"wchill":"'.$this->mini_ptro .'",'. "\n");
        fputs($gauges, '"wchillTL":"'.$this->mini_ptro .'",'. "\n");
        fputs($gauges, '"heatindex":"'.$this->mini_ptro .'",'. "\n");//index de chaleur
        fputs($gauges, '"heatindexTH":"'.$this->mini_ptro .'",'. "\n");//index de chaleur
        fputs($gauges, '"humidex":"'.$this->humiditer .'",'. "\n");//Humiditer
        fputs($gauges, '"wlatest":"'.$this->anemo .'",'. "\n");//Vent
        fputs($gauges, '"wspeed":"'.$this->anemo.'",'. "\n");//Vitesse du vent
        fputs($gauges, '"wgust":"'.$this->anemo.'",'. "\n");//Rafale de vent
        fputs($gauges, '"wgustTM":"'.$this->anemo.'",'. "\n");//Rafale de vent
        fputs($gauges, '"bearing":"'.$this->pression_ajt.'",'. "\n");//Palier
        fputs($gauges, '"avgbearing":"'.$this->pression_ajt.'",'. "\n");//Palier
        fputs($gauges, '"press":"'.$this->pression_ajt.'",'. "\n");//Pression atmo
        fputs($gauges, '"pressTL":"'.$this->mini_pres.'",'. "\n");//Mini pression atmo
        fputs($gauges, '"pressTH":"'.$this->maxi_pres.'",'. "\n");//Maxi pression atmo
        fputs($gauges, '"pressL":"'.$this->mini_pres.'",'. "\n");//Pression atmo mini
        fputs($gauges, '"pressH":"'.$this->maxi_pres.'",'. "\n");//Pression atmo maxi
        fputs($gauges, '"rfall":"0.5",'. "\n");//Pluvio
        fputs($gauges, '"rrate":"0.0",'. "\n");//Pluvio
        fputs($gauges, '"rrateTM":"0",'. "\n");//??
        fputs($gauges, '"hum":"'.$this->humiditer .'",'. "\n");//Humiditer
        fputs($gauges, '"humTL":"'.$this->mini_humi .'",'. "\n");//Mini humiditer
        fputs($gauges, '"humTH":"'.$this->maxi_humi .'",'. "\n");//Maxi humiditer
        fputs($gauges, '"inhum":"'.$this->humiditer .'",'. "\n");//Humiditer interieur
        fputs($gauges, '"SensorContactLost":"0",'. "\n"); //???
        fputs($gauges, '"forecast":"0",'. "\n");//Prevoir
        fputs($gauges, '"tempunit":"C",'. "\n");//Unite temperature
        fputs($gauges, '"windunit":"Km/h",'. "\n");//Unite vent
        fputs($gauges, '"pressunit":"hPa",'. "\n");//Unite pression
        fputs($gauges, '"rainunit":"mm",'. "\n");//Unite pluvio
        fputs($gauges, '"temptrend":"-3.3",'. "\n");//Ratraprage temperature
        fputs($gauges, '"TtempTL":"'. $this->heure . '",'. "\n");//Heure prise mini temp
        fputs($gauges, '"TtempTH":"'. $this->heure . '",'. "\n");//Heure prise maxi temp
        fputs($gauges, '"TdewpointTL":"'. $this->heure . '",'. "\n");//Heure prise mini point de rosee
        fputs($gauges, '"TdewpointTH":"'. $this->heure . '",'. "\n");//Heure prise maxi point de rosee
        fputs($gauges, '"TapptempTL":"'. $this->heure . '",'. "\n");//Heure prise mini ??
        fputs($gauges, '"TapptempTH":"'. $this->heure . '",'. "\n");//Heure prise mini ??
        fputs($gauges, '"TwchillTL":"'. $this->heure . '",'. "\n");//Heure prise mini ??
        fputs($gauges, '"TheatindexTH":"'. $this->heure . '",'. "\n");//Heure prise maxi index chaleur
        fputs($gauges, '"TrrateTM":"'. $this->heure . '",'. "\n");//Heure prise ??
        fputs($gauges, '"ThourlyrainTH":"'. $this->heure . '",'. "\n");//Heure prise ??
        fputs($gauges, '"LastRainTipISO":"'. $this->heure . '",'. "\n");//Heure prise ??
        fputs($gauges, '"hourlyrainTH":"'. $this->heure . '",'. "\n");//Heure prise ??
        fputs($gauges, '"ThumTL":"'. $this->heure . '",'. "\n");//Heure prise mini humiditer
        fputs($gauges, '"ThumTH":"'. $this->heure . '",'. "\n");//Heure prise maxi humiditer
        fputs($gauges, '"TpressTL":"'. $this->heure . '",'. "\n");//Heure prise mini pression
        fputs($gauges, '"TpressTH":"'. $this->heure . '",'. "\n");//Heure prise maxi pression
        fputs($gauges, '"presstrendval":"2.1",'. "\n");//??
        fputs($gauges, '"presstrendval":"00:00",'. "\n");//??
        fputs($gauges, '"TwgustTM":"'. $this->heure. '",'. "\n");//??
        fputs($gauges, '"windTM":"'. $this->heure. '",'. "\n");//??
        fputs($gauges, '"bearingTM":"'. $this->heure. '",'. "\n");//??
        fputs($gauges, '"timeUTC":"'. $this->heure.'on'.$this->date.'",'. "\n");//??
        fputs($gauges, '"BearingRangeFrom10":"0",'. "\n");//??
        fputs($gauges, '"BearingRangeTo10":"0",'. "\n");//??
        fputs($gauges, '"UV":"0",'. "\n");//Indice UV
        fputs($gauges, '"UVTH":"00:00",'. "\n");//Indice maxi UV
        fputs($gauges, '"SolarRad":"0",'. "\n");//Radiation solaire
        fputs($gauges, '"SolarTM":"00:00",'. "\n");//Radiation solaire
        fputs($gauges, '"CurrentSolarMax":"0",'. "\n");//Radiation solaire
        fputs($gauges, '"domwinddir":"0",'. "\n");
        fputs($gauges, '"WindRoseData":[0,0,0,0,0,0,0,0],'. "\n");
        fputs($gauges, '"windrun":"0",'. "\n");
        fputs($gauges, '"version":"2.4.4",'. "\n");//Version des gauges
        fputs($gauges, '"build":"1",'. "\n");//build
        fputs($gauges, '"ver":"12" }');//build
        fclose($gauges);
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

    //Function pour calculs comparaison des mini/maxi
    function miniMaxi()
    {
        $fichier_sd = 'minimaxi.txt';
        $read = file($fichier_sd);
        //Recuperation des mini maxi pour le compare
        $this->mini_temp = $read[0];
        $this->maxi_temp = $read[1];
        $this->mini_humi = $read[2];
        $this->maxi_humi = $read[3];
        $this->mini_pres = $read[4];
        $this->maxi_pres = $read[5];
        $this->mini_lumi = $read[6];
        $this->maxi_lumi = $read[7];
        $this->mini_ptro = $read[8];
        $this->maxi_ptro = $read[9];
        $this->mini_anemo = $read[10];
        $this->maxi_anemo = $read[11];
        $this->mini_girou = $read[12];
        $this->maxi_girou = $read[13];
        $this->mini_pluvio = $read[14];
        $this->maxi_pluvio = $read[15];
        //Comparaison table journaliere
        if ($this->temp2 < $this->mini_temp){
            $this->mini_temp = $this->temp2;
        }
        if ($this->temp2 > $this->maxi_temp){
            $this->maxi_temp = $this->temp2;
        }

        if ($this->humiditer < $this->mini_humi){
            $this->mini_humi = $this->humiditer;
        }

        if ($this->humiditer > $this->maxi_humi){
            $this->maxi_humi = $this->humiditer;
        }

        if ($this->pression_ajt < $this->mini_pres){
            $this->mini_pres = $this->pression_ajt;
        }

        if ($this->pression_ajt > $this->maxi_pres){
            $this->maxi_pres = $this->pression_ajt;
        }

        if ($this->lumiere < $this->mini_lumi){
            $this->mini_lumi = $this->lumiere;
        }

        if ($this->lumiere > $this->maxi_lumi){
            $this->maxi_lumi = $this->lumiere;
        }

        if ($this->pt_rosee < $this->mini_ptro){
            $this->mini_ptro = $this->pt_rosee;
        }

        if ($this->pt_rosee > $this->maxi_ptro){
            $this->maxi_ptro = $this->pt_rosee;
        }
        //PAs encore présent sur la station
        $this->mini_anemo = 0;
        $this->maxi_anemo = 0;
        $this->mini_girou = 0;
        $this->maxi_girou = 0;
        $this->mini_pluvio = 0;
        $this->maxi_pluvio = 0;


    }

    function essai()
    {
        $fichier_sd = 'station_direct.txt';
        $read = file($fichier_sd);
        return $read[6];
    }
}