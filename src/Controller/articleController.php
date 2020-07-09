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


class articleController extends AbstractController
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
     * @Route("/show/{id}", name="article.show")
     * @param Request $request
     * @return Response
     */
    public function show($id)
    {
    	$article = $this->repotisory->find($id);
        return $this->render('article/article_show.html.twig',[
        	'article' => $article
        ]);
    }
}