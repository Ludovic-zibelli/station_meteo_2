<?php
namespace App\Notification;

use App\Entity\AlertMeteo;
use App\Repository\AlertMeteoRepository;
use App\Repository\VigilanceMeteofranceRepository;
use Doctrine\ORM\EntityManagerInterface;

class AlerteMeteoNotification
{

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var AlertMeteoRepository
     */
    private $repo;

    /**
     * @var twitterNotification
     */
    private $twitter_notif;

    /**
     * @var VigilanceMeteofranceRepository
     */
    private $vigilance_repo;


    public function __construct(EntityManagerInterface $em, AlertMeteoRepository $repo, twitterNotification $twitter_notif, VigilanceMeteofranceRepository $vigilance_repo)
    {

        $this->em = $em;
        $this->repo = $repo;
        $this->twitter_notif = $twitter_notif;
        $this->vigilance_repo = $vigilance_repo;
    }

    public function calculAlerteTempAuto($temperature)
    {
        $alert_auto = $this->repo->findByType(1);
        $alerteAuto = new AlertMeteo();
        if($alert_auto[0]->getOnline() == false)
        {
            if ($temperature <= 3)
            {

                $alerteAuto->setType(false);
                $alerteAuto->setOnline(true);
                $alerteAuto->setLevel(2);
                $alerteAuto->setMessage('ATTENTION RISQUE DE VERGLAS');
                $alerteAuto->setCodePhenomene(5);
                $alerteAuto->setType(1);
                $alerteAuto->setOrigine('Alerte Auto');
                $alerteAuto->setPictogramme('logo_meteo.png');
                $this->em->persist($alerteAuto);
                $this->em->flush();
            }
        }

        if ($temperature >= 4)
        {
            $alert_auto[0]->setOnline(false);
            $this->em->flush();

        }

    }

    public function alerteTwitter()
    {
        $alerte_repo = $this->repo->findByAlerteAuto();
        $date = $alerte_repo[0]->getCreatdAt();
        $date_string = $date->format('d/m/Y à H:i:s');
        $message = $date_string. ' : "' .$alerte_repo[0]->getMessage(). '"';
        $this->twitter_notif->alerteMeteoTwitter($message);

        //if($alerte_repo[0]->getOnline() == 1)
        //{
            //$message = 'Alerte Météo declenche le $alerte_repo[0]->getCreatdAt() :$alerte_repo[0]->getMessage()';
            //$this->twitter_notif->alerteMeteoTwitter($message);
        //}
    }

    public function vigilanceMeteoFrance()
    {
        //Recuperation des données de vigilance Météo France
        $data = $this->vigilance_repo->findByVigilance();
        //Recuperation des données d'alerte automatique
        $alert_auto = $this->repo->findByType(false);
        //dd($alert_auto);

        if ((int)$data[0]->getRiskCode() >= 2) {
            $text = $data[0]->getText1() . $data[0]->getText2() . $data[0]->getText3() . $data[0]->getText4() . $data[0]->getText5()
                . $data[0]->getText21() . $data[0]->getText22() . $data[0]->getText23() . $data[0]->getText24() . $data[0]->getText25();

            // Vérifie si une alerte identique existe déjà
            $alerteExistante = $this->repo->findOneBy([
                'level' => $data[0]->getRiskCode(),
                'message' => $text,
                'code_phenomene' => $data[0]->getHazardCode(),
                'type' => false,
                'origine' => 'Météo France',
                'online' => true
            ]);

            if (!$alerteExistante) {
                $vigilance = new AlertMeteo();
                $vigilance->setOnline(true);
                $vigilance->setLevel($data[0]->getRiskCode());
                $vigilance->setMessage($text);
                $vigilance->setCodePhenomene($data[0]->getHazardCode());
                $vigilance->setOrigine('Météo France');
                $vigilance->setPictogramme('meteo-france.jpeg');
                $vigilance->setType(false);
                $this->em->persist($vigilance);
                $this->em->flush();
            }
            // Sinon, rien à faire (l'alerte existe déjà)
        }
        
        if ($data[0]->getRiskCode() == 1 && $alert_auto[0]->getType() ==  false && $alert_auto[0]->getOnline() == true) {
            $alert_auto[0]->setOnline(0);
            $this->em->flush();
        }
    }

    public function getAlerteMeteoMFStationDirect()
    {
        $alerte = $this->repo->findByAlerteAuto();
        return $alerte;
    }
}