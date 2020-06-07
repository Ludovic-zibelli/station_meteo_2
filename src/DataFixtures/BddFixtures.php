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

    }
}
