<?php

namespace App\DataFixtures;

use App\Entity\MiniMaxiH;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class BddFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $minimaxi = new MiniMaxiH();
       $minimaxi->setMiniTemp('10');
       $minimaxi->setMaxiTemp('10');
       $minimaxi->setMiniHumi('50');
       $minimaxi->setMaxiHumi('50');
       $minimaxi->setMiniPres('900');
       $minimaxi->setMaxiPres('900');
       $minimaxi->setMiniPtro('3,50');
       $minimaxi->setMaxiPtro('3,50');
       $minimaxi->setMiniLumi('200');
       $minimaxi->setMaxiLumi('200');
       $minimaxi->setMiniAnemo('0');
       $minimaxi->setMaxiAnemo('0');
       $minimaxi->setMiniGirou('0');
       $minimaxi->setMaxiGirou('0');
       $minimaxi->setMiniPluvio('0');
       $minimaxi->setMaxiPluvio('0');

       $manager->flush();

    }
}
