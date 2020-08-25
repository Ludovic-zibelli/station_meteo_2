<?php
namespace App\Notification;

use App\Entity\AlertMeteo;
use App\Repository\AlertMeteoRepository;
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

    public function __construct(EntityManagerInterface $em, AlertMeteoRepository $repo, twitterNotification $twitter_notif)
    {

        $this->em = $em;
        $this->repo = $repo;
        $this->twitter_notif = $twitter_notif;
    }

    public function calculAlerteTempAuto($temperature)
    {
        $alert_auto = $this->repo->findByAlerteAuto();
        $alerteAuto = new AlertMeteo();
        if($alert_auto[0]->getLevel() == 1 && $alert_auto[0]->getOnline() == false)
        {
            if ($temperature <= 3)
            {

                $alerteAuto->setType(false);
                $alerteAuto->setOnline(true);
                $alerteAuto->setLevel(1);
                $alerteAuto->setMessage('ATTENTION RISQUE DE VERGLAS');
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
}