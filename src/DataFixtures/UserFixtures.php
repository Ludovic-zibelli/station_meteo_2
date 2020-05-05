<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
	/**
	* @var UserPasswordEncoderInterface
	**/
	public function __construct(UserPasswordEncoderInterface $encoder)
	{
		$this->encoder = $encoder;
	}

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setNom('ZIBELLI');
        $user->setPrenom('Ludovic');
        $user->setEmail('ludovic.zibelli@free.fr');
        $user->setPassword($this->encoder->encodePassword($user, 'Maelys09'));
        $manager->persist($user);

        $manager->flush();
    }
}
