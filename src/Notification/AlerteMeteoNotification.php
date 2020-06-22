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

    public function __construct(EntityManagerInterface $em, AlertMeteoRepository $repo)
    {

        $this->em = $em;
        $this->repo = $repo;
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
}