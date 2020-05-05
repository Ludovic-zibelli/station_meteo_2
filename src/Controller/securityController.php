<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class securityController extends AbstractController
{

	/**
     * @Route("/login", name="login")
     * @param Request $request
     * @return Response
     */
	public function login(AuthenticationUtils $AuthenticationUtils)
	{
	    $error = $AuthenticationUtils->getLastAuthenticationError();
	    $lastUsername = $AuthenticationUtils->getLastUsername();
		return $this->render('security/login.html.twig', [
		    'last_user' => $lastUsername,
            'error' => $error
        ]);
	}
}