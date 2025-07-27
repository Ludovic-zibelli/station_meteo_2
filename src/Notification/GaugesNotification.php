<?php

namespace App\Notification;

use App\Entity\Station;
use App\Repository\MiniMaxiHRepository;
use App\Repository\StationDirectRepository;
use App\Repository\StationRepository;

class GaugesNotification
{

/**
* @var StationRepository
*/
private $station_direct;

/**
* @var mini_maxi_h
*/
private $mini_maxi_h;

/**
* @var station
*/
private $station;

function __construct(StationDirectRepository $station_direct, MiniMaxiHRepository $mini_maxi_h, StationRepository $station)
{
    $this->station_direct = $station_direct;
    $this->mini_maxi_h = $mini_maxi_h;
    $this->station = $station;
}



//Modification ficher realtilegauges.txt pour les gauges
function realTimeGauges($stationId)
{

    //Recuperation des donnees de la station
    $station = $this->station->findByStationId($stationId);
    
    $data = $this->station_direct->findByStationId($stationId);
    $dataMM = $this->mini_maxi_h->findAll();
    //dd($station);
    
    $pt_rosee = $this->ptRosee($data[0]->getTempdh22(), $data[0]->getHumidite());
    $heure = $data[0]->getDateheure()->format('H:i:s');
    $date = $data[0]->getDateheure()->format('d/m/Y');
    //dd($dataMM[0]->getMiniTemp());

    //Mise en forme dans le fichier gauges realtimegauges.txt
    $gauges = fopen('realtimegauges.txt' ,'w+');
    if (!$gauges) {
    throw new \Exception('Impossible d\'ouvrir le fichier realtimegauges.txt pour écriture.');
    }
    fseek($gauges, 0);
    fputs($gauges, '{"date":"'. $heure . '",'. "\n" );
    fputs($gauges, '"temp":"'.$data[0]->getTempdh22().'",' . "\n" );//Temperature
    fputs($gauges, '"tempTL":"'. $dataMM[0]->getMiniTemp() .'",'."\n");//Temperature Mini
    fputs($gauges, '"tempTH":"'. $dataMM[0]->getMaxiTemp() .'",'. "\n" );//Temperature maxi
    fputs($gauges, '"intemp":"'.$data[0]->getTempbmp280().'",' . "\n" );//Temperature interieur
    fputs($gauges, '"dew":"'.$pt_rosee.'",' . "\n" );//Point de rosee
    fputs($gauges, '"dewpointTL":"'.$dataMM[0]->getMiniPtro() .'",' . "\n");//Point de rosee mini
    fputs($gauges, '"dewpointTH":"'.$dataMM[0]->getMaxiPtro() .'",' . "\n");//Poinrt de rosee maxi
    fputs($gauges, '"apptemp":"'.$dataMM[0]->getMiniPtro() .'",' . "\n");
    fputs($gauges, '"apptempTL":"'.$dataMM[0]->getMiniPtro() .'",' . "\n");
    fputs($gauges, '"apptempTH":"'.$dataMM[0]->getMiniPtro().'",' . "\n");
    fputs($gauges, '"wchill":"'.$dataMM[0]->getMiniPtro() .'",'. "\n");
    fputs($gauges, '"wchillTL":"'.$dataMM[0]->getMiniPtro() .'",'. "\n");
    fputs($gauges, '"heatindex":"'.$dataMM[0]->getMiniPtro() .'",'. "\n");//index de chaleur
    fputs($gauges, '"heatindexTH":"'.$dataMM[0]->getMiniPtro() .'",'. "\n");//index de chaleur
    fputs($gauges, '"humidex":"'.$data[0]->getHumidite() .'",'. "\n");//Humiditer
    fputs($gauges, '"wlatest":"'.$station->getAnemometre() .'",'. "\n");//Vent
    fputs($gauges, '"wspeed":"'.$data[0]->getAnemometre().'",'. "\n");//Vitesse du vent
    fputs($gauges, '"wgust":"'.$dataMM[0]->getMaxiAnemo().'",'. "\n");//Rafale de vent
    fputs($gauges, '"wgustTM":"'.$dataMM[0]->getMiniAnemo().'",'. "\n");//Rafale de vent
    fputs($gauges, '"bearing":"'.$data[0]->getGirouette().'",'. "\n");//Girouette
    fputs($gauges, '"avgbearing":"'.$station->getGirouette().'",'. "\n");//Girouette
    fputs($gauges, '"press":"'.$data[0]->getPression().'",'. "\n");//Pression atmo
    fputs($gauges, '"pressTL":"'.$dataMM[0]->getMiniPres().'",'. "\n");//Mini pression atmo
    fputs($gauges, '"pressTH":"'.$dataMM[0]->getMaxiPres().'",'. "\n");//Maxi pression atmo
    fputs($gauges, '"pressL":"'.$dataMM[0]->getMiniPres().'",'. "\n");//Pression atmo mini
    fputs($gauges, '"pressH":"'.$dataMM[0]->getMaxiPres().'",'. "\n");//Pression atmo maxi
    fputs($gauges, '"rfall":"'.$data[0]->getPluviometre().'",'. "\n");//Pluvio
    fputs($gauges, '"rrate":"0.0",'. "\n");//Pluvio
    fputs($gauges, '"rrateTM":"0",'. "\n");//??
    fputs($gauges, '"hum":"'.$data[0]->getHumidite()  .'",'. "\n");//Humiditer
    fputs($gauges, '"humTL":"'.$dataMM[0]->getMiniHumi() .'",'. "\n");//Mini humiditer
    fputs($gauges, '"humTH":"'.$dataMM[0]->getMaxiHumi() .'",'. "\n");//Maxi humiditer
    fputs($gauges, '"inhum":"'.$data[0]->getHumidite()  .'",'. "\n");//Humiditer interieur
    fputs($gauges, '"SensorContactLost":"0",'. "\n"); //???
    fputs($gauges, '"forecast":"0",'. "\n");//Prevoir
    fputs($gauges, '"tempunit":"C",'. "\n");//Unite temperature
    fputs($gauges, '"windunit":"Km/h",'. "\n");//Unite vent
    fputs($gauges, '"pressunit":"hPa",'. "\n");//Unite pression
    fputs($gauges, '"rainunit":"mm",'. "\n");//Unite pluvio
    fputs($gauges, '"temptrend":"-3.3",'. "\n");//Ratraprage temperature
    fputs($gauges, '"TtempTL":"'. $heure . '",'. "\n");//Heure prise mini temp
    fputs($gauges, '"TtempTH":"'. $heure . '",'. "\n");//Heure prise maxi temp
    fputs($gauges, '"TdewpointTL":"'. $heure . '",'. "\n");//Heure prise mini point de rosee
    fputs($gauges, '"TdewpointTH":"'. $heure . '",'. "\n");//Heure prise maxi point de rosee
    fputs($gauges, '"TapptempTL":"'. $heure . '",'. "\n");//Heure prise mini ??
    fputs($gauges, '"TapptempTH":"'. $heure . '",'. "\n");//Heure prise mini ??
    fputs($gauges, '"TwchillTL":"'. $heure . '",'. "\n");//Heure prise mini ??
    fputs($gauges, '"TheatindexTH":"'. $heure . '",'. "\n");//Heure prise maxi index chaleur
    fputs($gauges, '"TrrateTM":"'. $heure . '",'. "\n");//Heure prise ??
    fputs($gauges, '"ThourlyrainTH":"'. $heure . '",'. "\n");//Heure prise ??
    fputs($gauges, '"LastRainTipISO":"'. $heure . '",'. "\n");//Heure prise ??
    fputs($gauges, '"hourlyrainTH":"'. $heure . '",'. "\n");//Heure prise ??
    fputs($gauges, '"ThumTL":"'. $heure . '",'. "\n");//Heure prise mini humiditer
    fputs($gauges, '"ThumTH":"'. $heure . '",'. "\n");//Heure prise maxi humiditer
    fputs($gauges, '"TpressTL":"'. $heure . '",'. "\n");//Heure prise mini pression
    fputs($gauges, '"TpressTH":"'. $heure . '",'. "\n");//Heure prise maxi pression
    fputs($gauges, '"presstrendval":"2.1",'. "\n");//??
    fputs($gauges, '"presstrendval":"00:00",'. "\n");//??
    fputs($gauges, '"TwgustTM":"'. $heure. '",'. "\n");//??
    fputs($gauges, '"windTM":"'. $heure. '",'. "\n");//??
    fputs($gauges, '"bearingTM":"'. $heure. '",'. "\n");//??
    fputs($gauges, '"timeUTC":"'. $heure.'on'.$date.'",'. "\n");//??
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

    //Calcul du point de rosee
    function ptRosee($temp, $humiditer)
    {

        $T = $temp;
        $H = $humiditer;
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

}