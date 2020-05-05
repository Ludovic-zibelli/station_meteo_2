<?php

namespace App\Controller;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArcticlesRepository;


class stationController extends AbstractController
{
	
	/**
	*@var ArcticlesRepository
	*/
	private $repotisory;

	

	public function __construct(ArcticlesRepository $repotisory)
	{
		$this->repotisory = $repotisory;
		
	}

	 /**
     * @Route("/", name="home")
     * @param Request $request
     * @param ArcticlesRepository $repotisory
     * @return Response
     */
    public function home()
    {
    	$articles = $this->repotisory->findLatest();
        return $this->render('station/index.html.twig', [
        	'articles' => $articles
        ]);
    }

     /**
     * @Route("/historique", name="historique")
     * @param Request $request
     * @return Response
     */
    public function historique()
    {
        return $this->render('station/historique.html.twig');
    }


    /**
     * @Route("/presentation", name="presentation")
     * @param Request $request
     * @return Response
     */
    public function presentation()
    {
        return $this->render('station/presentation_station.html.twig');
    }

                /**
     * @Route("/mention_legales", name="mentionlegales")
     * @param Request $request
     * @return Response
     */
    public function mention()
    {
        return $this->render('station/mention_legales.html.twig');
    }
}


