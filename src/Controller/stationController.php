<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Recherche;
use App\Form\ContactType;
use App\Form\RechercheType;
use App\Notification\ContactNotification;
use App\Notification\GetStationNotification;
use App\Notification\GrapheNotification;
use App\Notification\MiniMaxiNotification;
use App\Repository\MiniMaxiRepository;
use App\Repository\StationRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
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
    public function home(Request $request, ContactNotification $notification)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $notification->notify($contact);
            $this->addFlash('success', 'Votre message a bien été envoyer');
            return $this->redirectToRoute('home');
        }
    	$articles = $this->repotisory->findLatest();
        return $this->render('station/index.html.twig', [
        	'articles' => $articles,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/historique", name="historique")
     * @param StationRepository $stationrepo
     * @return Response
     */
    public function historique(StationRepository $stationrepo, GrapheNotification $graph, Request $request, MiniMaxiRepository $minimaxirepo)
    {
        $station = $stationrepo->findByGraph();
        $chartT = $graph->temperature($station);
        $chartP = $graph->pression($station);
        $chartH = $graph->humidite($station);
        $recherche = new Recherche();
        $form = $this->createForm(RechercheType::class, $recherche);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $resultat = $stationrepo->findSearch($recherche);
            $chartTR = $graph->temperature($resultat);
            $count = $stationrepo->getNb($recherche);
            return $this->render('station/Recherche.html.twig',[
                'resultats' => $resultat,
                'count' => $count,
                'chartTR' => $chartTR

            ]);
        }
        $minimaxi = $minimaxirepo->findMiniMax();
        return $this->render('station/historique.html.twig', [
            'chartT' => $chartT,
            'chartP' => $chartP,
            'chartH' => $chartH,
            'minimaxi' => $minimaxi,
            'form'   => $form->createView()
        ]);
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

    /**
     * @Route("getstation", name="getstation")
     * @param Request $request
     * @return Response
     */
    public function getStation(Request $request, GetStationNotification $getstation, MiniMaxiNotification $minimax)
    {
        //$getstation->getStation($request);
        $temp1 = $request->get('temp1');
        $essai = 300;
        $minimax->getMinimaxi($request);
        return $this->render('station/essai.html.twig', [
            'essai' => $essai
        ]);
    }
}


