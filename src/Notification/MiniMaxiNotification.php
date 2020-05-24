<?php

namespace App\Notification;

use phpDocumentor\Reflection\File;

class MiniMaxiNotification
{
    /**
     * @var int
     */
    private $temp1;

    /**
     * @var int
     */
    private $temp2;

    /**
     * @var int
     */
    private $humiditer;

    /**
     * @var int
     */
    private $pression;

    /**
     * @var int
     */
    private $lumiere;

    /**
     * @var int
     */
    private $tension;

    /**
     * @var int
     */
    private $pression_ajt;

    /**
     * @var string
     */
    private $pt_rosee;

    /**
     * @var int
     */
    private $pluvio;

    /**
     * @var int
     */
    private $anemo;

    /**
     * @var int
     */
    private $girou;

    /**
     * @var int
     */
    private $mini_temp = 0;

    private $mini_temp_1 = 0;

    /**
     * @var int
     */
    private $maxi_temp = 0;

    private $maxi_temp_1 = 0;

    /**
     * @var int
     */
    private $mini_humi = 0;

    private $mini_humi_1 = 0;

    /**
     * @var int
     */
    private $maxi_humi = 0;

    private $maxi_humi_1 = 0;

    /**
     * @var int
     */
    private $mini_pres = 0;

    private $mini_pres_1 = 0;

    /**
     * @var int
     */
    private $maxi_pres = 0;

    private $maxi_pres_1 = 0;

    /**
     * @var int
     */
    private $mini_lumi = 0;

    private $mini_lumi_1 = 0;

    /**
     * @var int
     */
    private $maxi_lumi = 0;

    private $maxi_lumi_1 = 0;
    /**
     * @var int
     */
    private $mini_ptro = 0;

    private $mini_ptro_1 = 0;

    /**
     * @var string
     */
    private $maxi_ptro = 0;

    private $maxi_ptro_1 = 0;

    /**
     * @var string
     */
    private $mini_anemo = 0;

    private $mini_anemo_1 = 0;

    /**
     * @var int
     */
    private $maxi_anemo = 0;

    private $maxi_anemo_1 = 0;

    /**
     * @var int
     */
    private $mini_girou = 0;

    private $mini_girou_1 = 0;

    /**
     * @var int
     */
    private $maxi_girou = 0;

    private $maxi_girou_1 = 0;

    /**
     * @var int
     */
    private $mini_pluvio = 0;

    private $mini_pluvio_1 = 0;

    /**
     * @var int
     */
    private $maxi_pluvio = 0;

    private $maxi_pluvio_1 = 0;


    function getMinimaxi($request)
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

        // Lit un fichier, et le place dans une chaîne
        //$filename = "minimaxi.txt";
        //$handle = fopen ($filename, "r");
        //$read = fread ($handle, filesize ($filename));
        //fclose ($handle);
        $read = file('minimaxi.txt');
        //Recuperation des mini maxi
        $fichier_sd = 'minimaxi.txt';
        $read = file($fichier_sd);
        //Recuperation des mini maxi pour le compar
        $this->mini_temp = $read[0];
        $this->maxi_temp = $read[2];
        $this->mini_humi = $read[3];
        $this->maxi_humi = $read[5];
        $this->mini_pres = $read[6];
        $this->maxi_pres = $read[8];
        $this->mini_lumi = $read[9];
        $this->maxi_lumi = $read[11];
        $this->mini_ptro = $read[19];
        $this->maxi_ptro = $read[20];



        $this->miniMaxi();
        //$this->fichierMn();
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

    //Function pour calculs comparaison des mini/maxi
    function miniMaxi()
    {

        //Comparaison table journaliere
        if ($this->temp2 < $this->mini_temp)
        {
            $this->mini_temp = $this->temp2;
        }else
        {
            $this->mini_temp = $this->mini_temp;
        }

        if ($this->temp2 > $this->maxi_temp)
        {
            $this->maxi_temp = $this->temp2;
        }
        else
        {
            $this->maxi_temp = $this->maxi_temp;
        }

        if ($this->humiditer < $this->mini_humi)
        {
            $this->mini_humi = $this->humiditer;
        }
        else
        {
            $this->mini_humi = $this->mini_humi;
        }

        if ($this->humiditer > $this->maxi_humi)
        {
            $this->maxi_humi = $this->humiditer;
        }
        else
        {
            $this->mini_humi = $this->maxi_humi;
        }

        if ($this->pression_ajt < $this->mini_pres)
        {
            $this->mini_pres = $this->pression_ajt;
        }
        else
        {
            $this->mini_pres = $this->mini_pres;
        }

        if ($this->pression_ajt > $this->maxi_pres)
        {
            $this->maxi_pres = $this->pression_ajt;
        }
        else
        {
            $this->maxi_pres = $this->maxi_pres;
        }

        if ($this->lumiere < $this->mini_lumi)
        {
            $this->mini_lumi = $this->lumiere;
        }
        else
        {
            $this->mini_lumi = $this->mini_lumi;
        }

        if ($this->lumiere > $this->maxi_lumi)
        {
            $this->maxi_lumi = $this->lumiere;
        }
        else
        {
            $this->maxi_lumi = $this->maxi_lumi;
        }

        if ($this->pt_rosee < $this->mini_ptro)
        {
            $this->mini_ptro = $this->pt_rosee;
        }
        else
        {
            $this->mini_ptro = $this->mini_ptro;
        }

        if ($this->pt_rosee > $this->maxi_ptro)
        {
            $this->maxi_ptro = $this->pt_rosee;
        }
        else
        {
            $this->maxi_ptro = $this->maxi_ptro;
        }
        //PAs encore présent sur la station
        $this->mini_anemo = 0;
        $this->maxi_anemo = 0;
        $this->mini_girou = 0;
        $this->maxi_girou = 0;
        $this->mini_pluvio = 0;
        $this->maxi_pluvio = 0;

        $this->fichierMn();
    }

    function fichierMn()
    {
        $monfichierMn = fopen('minimaxi.txt', 'w+');
        fseek($monfichierMn, 0);
        fputs($monfichierMn, $this->mini_temp. "\n");
        fputs($monfichierMn, $this->maxi_temp. "\n" );
        fputs($monfichierMn, $this->mini_humi. "\n" );
        fputs($monfichierMn, $this->maxi_humi. "\n" );
        fputs($monfichierMn, $this->mini_pres. "\n" );
        fputs($monfichierMn, $this->maxi_pres. "\n" );
        fputs($monfichierMn, $this->mini_lumi. "\n" );
        fputs($monfichierMn, $this->maxi_lumi. "\n" );
        fputs($monfichierMn, $this->mini_anemo. "\n" );
        fputs($monfichierMn, $this->maxi_anemo. "\n" );
        fputs($monfichierMn, $this->mini_girou. "\n" );
        fputs($monfichierMn, $this->maxi_girou. "\n" );
        fputs($monfichierMn, $this->mini_pluvio. "\n" );
        fputs($monfichierMn, $this->maxi_pluvio. "\n" );
        fputs($monfichierMn, $this->mini_ptro. "\n" );
        fputs($monfichierMn, $this->maxi_ptro. "\n" );
        fclose($monfichierMn);
    }
}