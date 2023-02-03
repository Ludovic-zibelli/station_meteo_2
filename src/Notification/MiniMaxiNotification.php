<?php

namespace App\Notification;


use App\Repository\MiniMaxiHRepository;
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
     * MiniMaxiNotification constructor.
     * @param EntityManagerInterface $em
     * @param MiniMaxiHRepository $repo
     */
    public function __construct(EntityManagerInterface $em, MiniMaxiHRepository $repo )
    {
        $this->em = $em;
        $this->repo = $repo;
    }

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
        $this->pluvio = $request->get('pluvio');
        $this->anemo = $request->get('anemo');
        $this->girou = $request->get('girou');

        $bdd = $this->repo->findByMini();

        //Comparaison table journaliere
        if ($this->temp2 < $bdd[0]->getMiniTemp())
        {
            $bdd[0]->setMiniTemp($this->temp2);
            //$this->mini_temp = $this->temp2;
        }

        if ($this->temp2 > $bdd[0]->getMaxiTemp())
        {
            $bdd[0]->setMaxiTemp($this->temp2);
            //$this->maxi_temp = $this->temp2;
        }


        if ($this->humiditer < $bdd[0]->getMiniHumi())
        {
            $bdd[0]->setMiniHumi($this->humiditer);
            //$this->mini_humi = $this->humiditer;
        }

        if ($this->humiditer > $bdd[0]->getMaxiHumi())
        {
            $bdd[0]->setMaxiHumi($this->humiditer);
            //$this->maxi_humi = $this->humiditer;
        }

        if ($this->pression_ajt < $bdd[0]->getMiniPres())
        {
            $bdd[0]->setMiniPres($this->pression_ajt);
            //$this->mini_pres = $this->pression_ajt;
        }


        if ($this->pression_ajt > $bdd[0]->getMaxiPres())
        {
            $bdd[0]->setMaxiPres($this->pression_ajt);
            //$this->maxi_pres = $this->pression_ajt;
        }

        if ($this->lumiere < $bdd[0]->getMiniLumi())
        {
            $bdd[0]->setMiniLumi($this->lumiere);
            //$this->mini_lumi = $this->lumiere;
        }


        if ($this->lumiere > $bdd[0]->getMaxiLumi())
        {
            $bdd[0]->setMaxiLumi($this->lumiere);
            //$this->maxi_lumi = $this->lumiere;
        }

        if ($this->pt_rosee < $bdd[0]->getMiniPtro())
        {
            $bdd[0]->setMiniPtro($this->pt_rosee);
            //$this->mini_ptro = $this->pt_rosee;
        }

        if ($this->pt_rosee > $bdd[0]->getMaxiPtro())
        {
            $bdd[0]->setMaxiPtro($this->pt_rosee);
            //$this->maxi_ptro = $this->pt_rosee;
        }

        //Controle mini maxi anemo
        if ($this->anemo < $bdd[0]->getMiniAnemo())
        {
            $bdd[0]->setMiniAnemo($this->anemo);
            //$this->mini_ptro = $this->pt_rosee;
        }

        if ($this->anemo > $bdd[0]->getMaxiAnemo())
        {
            $bdd[0]->setMaxiAnemo($this->anemo);
            //$this->maxi_ptro = $this->pt_rosee;
        }

        //Controle mini maxi girou
        if ($this->girou < $bdd[0]->getMiniGirou())
        {
            $bdd[0]->setMiniGirou($this->girou);
            //$this->mini_ptro = $this->pt_rosee;
        }

        if ($this->girou > $bdd[0]->getMaxiGirou())
        {
            $bdd[0]->setMaxiGirou($this->girou);
            //$this->maxi_ptro = $this->pt_rosee;
        }

        //Controle mini maxi pluviometre
        if ($this->pluvio < $bdd[0]->getMiniPluvio())
        {
            $bdd[0]->setMiniPluvio($this->pluvio);
            //$this->mini_ptro = $this->pt_rosee;
        }

        if ($this->pluvio > $bdd[0]->getMaxiPluvio())
        {
            $bdd[0]->setMaxiPluvio($this->pluvio);
            //$this->maxi_ptro = $this->pt_rosee;
        }


        $this->em->flush();

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


}