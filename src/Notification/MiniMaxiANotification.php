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

    public function minimaxicompare()
    {
        $bdd = $this->mnh->findByMini();
        $bdd2 = $this->mna->findByMiniA();

        if ($bdd[0]->getMiniTemp() < $bdd2[0]->getMiniTemp())
        {
            $bdd2[0]->setMiniTemp($bdd[0]->getMiniTemp());
            $bdd2[0]->setDateMiniTemp($this->date_time);
        }

        if ($bdd[0]->getMaxiTemp() > $bdd2[0]->getMaxiTemp())
        {
            $bdd2[0]->setMaxiTemp($bdd[0]->getMaxiTemp());
            $bdd2[0]->setDateMaxiTemp($this->date_time);
        }


        if ($bdd[0]->getMiniHumi() < $bdd2[0]->getMiniHumi())
        {
            $bdd2[0]->setMiniHumi($bdd[0]->getMiniHumi());
            $bdd2[0]->setDateMiniHumi($this->date_time);
        }

        if ($bdd[0]->getMaxiHumi() > $bdd2[0]->getMaxiHumi())
        {
            $bdd2[0]->setMaxiHumi($bdd[0]->getMaxiHumi());
            $bdd2[0]->setDateMaxiHumi($this->date_time);
        }

        if ($bdd[0]->getMiniPres()< $bdd2[0]->getMiniPres())
        {
            $bdd2[0]->setMiniPres($bdd[0]->getMiniPres());
            $bdd2[0]->setDateMiniPres($this->date_time);
        }

        if ($bdd[0]->getMaxiPres() > $bdd2[0]->getMaxiPres())
        {
            $bdd2[0]->setMaxiPres($bdd[0]->getMaxiPres());
            $bdd2[0]->setDateMaxiPres($this->date_time);
        }

        if ($bdd[0]->getMiniLumi() < $bdd2[0]->getMiniLumi())
        {
            $bdd2[0]->setMiniLumi($bdd[0]->getMiniLumi());
            $bdd2[0]->setDateMiniLumi($this->date_time);
        }

        if ($bdd[0]->getMaxiLumi() > $bdd2[0]->getMaxiLumi())
        {
            $bdd2[0]->setMaxiLumi($bdd[0]->getMaxiLumi());
            $bdd2[0]->setDateMaxiLumi($this->date_time);
        }

        if ($bdd[0]->getMiniPtro() < $bdd2[0]->getMiniPtro())
        {
            $bdd2[0]->setMiniPtro($bdd[0]->getMiniPtro());
            $bdd2[0]->setDateMiniPtro($this->date_time);
        }

        if ($bdd[0]->getMaxiPtro() > $bdd2[0]->getMaxiPtro())
        {
            $bdd2[0]->setMaxiPtro($bdd[0]->getMaxiPtro());
            $bdd2[0]->setDateMaxiPtro($this->date_time);
        }

        //Pas encore présent sur la station
        if ($bdd[0]->getMiniAnemo() < $bdd2[0]->getMiniAnemo())
        {
            $bdd2[0]->setMiniAnemo($bdd[0]->getMiniAnemo());
            $bdd2[0]->setDateMiniAnemo($this->date_time);
        }

        if ($bdd[0]->getMaxiAnemo() > $bdd2[0]->getMaxiAnemo())
        {
            $bdd2[0]->setMaxiAnemo($bdd[0]->getMaxiAnemo());
            $bdd2[0]->setDateMaxiAnemo($this->date_time);
        }

        if ($bdd[0]->getMiniGirou() < $bdd2[0]->getMiniGirou())
        {
            $bdd2[0]->setMiniGirou($bdd[0]->getMiniGirou());
            $bdd2[0]->setDateMiniGirou($this->date_time);
        }

        if ($bdd[0]->getMaxiGirou() > $bdd2[0]->getMaxiGirou())
        {
            $bdd2[0]->setMaxiGirou($bdd[0]->getMaxiGirou());
            $bdd2[0]->setDateMaxiGirou($this->date_time);
        }

        if ($bdd[0]->getMiniPluvio() < $bdd2[0]->getMiniPluvio())
        {
            $bdd2[0]->setMiniPluvio($bdd[0]->getMiniPluvio());
            $bdd2[0]->setDateMiniPluvio($this->date_time);
        }

        if ($bdd[0]->getMaxiPluvio() > $bdd[0]->getMaxiPluvio())
        {
            $bdd2[0]->setMaxiPluvio($bdd[0]->getMaxiPluvio());
            $bdd2[0]->setDateMaxiPluvio($this->date_time);
        }

        $this->em->flush();
    }
}