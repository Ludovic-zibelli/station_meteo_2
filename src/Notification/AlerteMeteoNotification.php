<?php
namespace App\Notification;

use App\Entity\AlertMeteo;
use Doctrine\ORM\EntityManagerInterface;

class AlerteMeteoNotification
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em )
    {

        $this->em = $em;
    }

    public function calculAlerte($temperature)
    {
        if ($temperature <= 3)
        {

        }
    }
}