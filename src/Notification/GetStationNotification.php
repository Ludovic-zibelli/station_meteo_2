<?php

namespace App\Notification;

use App\Entity\Station;
use App\Repository\MiniMaxiHRepository;
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

    /**
     * @var MiniMaxiHRepository
     */
    private $repo;

    function __construct(EntityManagerInterface $em, MiniMaxiHRepository $repo)
    {
        $this->date = date("d.m.Y");
        $this->heure = date("G:i");
        $this->em = $em;
        $this->repo = $repo;

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

    private $bitvie ;

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
        $this->bitvie = $request->get('bitvie');
        $this->pluvio = 0;
        $this->anemo = 0;
        $this->girou = 0;



        $this->minimaxi();
        //$this->addBdd();
        $this->realTimeGauges();
        $this->stationDirect();



    }
    //Modification du fichier station_direct.txt
    function stationDirect()
    {

        //Creation fichier TEXT
        $monfichierSD = fopen('station_direct.txt', 'w+');
        fseek($monfichierSD, 0);
        fputs($monfichierSD, $this->date . "\n");//0
        fputs($monfichierSD, $this->heure . "\n");//1
        fputs($monfichierSD, $this->temp1 . "\n");//2
        fputs($monfichierSD, $this->humiditer . "\n");//3
        fputs($monfichierSD, $this->temp2 . "\n");//4
        fputs($monfichierSD, $this->pression_ajt . "\n");//5
        fputs($monfichierSD, $this->lumiere . "\n");//6
        fputs($monfichierSD, $this->pluvio . "\n");//7
        fputs($monfichierSD, $this->anemo . "\n");//8
        fputs($monfichierSD, $this->girou . "\n");//9
        fputs($monfichierSD, $this->tension . "\n");//10
        fputs($monfichierSD, $this->pt_rosee . "\n");//11
        fputs($monfichierSD, $this->bitvie . "\n");
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




    //Recuperation des mini maxi de la table minimaxih
    function minimaxi()
    {

        $minimax = $this->repo->findByMini();

        $this->mini_temp = $minimax[0]->getMiniTemp();
        $this->maxi_temp = $minimax[0]->getMaxiTemp();
        $this->mini_humi = $minimax[0]->getMiniHumi();
        $this->maxi_humi = $minimax[0]->getMaxiHumi();
        $this->mini_pres = $minimax[0]->getMiniPres();
        $this->maxi_pres = $minimax[0]->getMaxiPres();
        $this->mini_lumi = $minimax[0]->getMiniLumi();
        $this->maxi_lumi = $minimax[0]->getMaxiLumi();
        $this->mini_ptro = $minimax[0]->getMiniPtro();
        $this->maxi_ptro = $minimax[0]->getMaxiPtro();
        $this->mini_pluvio = $minimax[0]->getMiniPluvio();
        $this->maxi_pluvio = $minimax[0]->getMaxiPluvio();
        $this->mini_girou = $minimax[0]->getMiniGirou();
        $this->maxi_girou = $minimax[0]->getMaxiGirou();
        $this->mini_anemo = $minimax[0]->getMiniAnemo();
        $this->maxi_anemo = $minimax[0]->getMaxiAnemo();

    }

}