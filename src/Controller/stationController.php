<?php

namespace App\Controller;

use App\Entity\AlertMeteo;
use App\Entity\Contact;
use App\Entity\MinimaxiSearch;
use App\Entity\Recherche;
use App\Entity\SiteConfig;
use App\Form\ContactType;
use App\Form\MinimaxiType;
use App\Form\RechercheType;
use App\Notification\AlerteMeteoNotification;
use App\Notification\BddNotification;
use App\Notification\ContactNotification;
use App\Notification\GetStationNotification;
use App\Notification\GrapheNotification;
use App\Notification\MiniMaxiANotification;
use App\Notification\MiniMaxiNotification;
use App\Notification\SaisonNotification;
use App\Notification\smsNotification;
use App\Notification\twitterNotification;
use App\Notification\CallApiService;
use App\Notification\GaugesNotification;
use App\Notification\OragesNotification;
use App\Notification\VigilanceMeteoFranceNotification;
use App\Repository\AlertMeteoRepository;
use App\Repository\MiniMaxiARepository;
use App\Repository\MiniMaxiHRepository;
use App\Repository\MiniMaxiRepository;
use App\Repository\StationRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArcticlesRepository;
use App\Repository\EtatStationMeteoRepository;
use App\Repository\SiteConfigRepository;
use App\Repository\StationMeteosRepository;
use Symfony\Component\VarDumper\VarDumper;
use Th3Mouk\FreeMobileSMSNotif\Client;
use Symfony\Component\HttpFoundation\JsonResponse;


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
     * @param ContactNotification $notification
     * @param AlertMeteoRepository $alerteRepo
     * @return Response
     */
    public function home(Request $request, ContactNotification $notification, AlertMeteoRepository $alerteRepo, SaisonNotification $saison, MiniMaxiHRepository $HRepository, StationMeteosRepository $stationMeteosRepository, SiteConfigRepository $siteConfigRepo)
    {
        // Dans chaque action publique
        // Récupération de la config (supposons qu'il n'y a qu'une ligne)
        $config = $siteConfigRepo->findOneBy([]);

        // Vérification du mode maintenance
        if ($config && $config->getMaintenance()) {
            return $this->render('station/maintenance.html.twig');
        }

        // Pour afficher/cacher le menu station dans le template
        $viewStation = $config ? $config->getViewStation() : true;
        $contact = new Contact();
        $stationmeteo = $stationMeteosRepository->findAll();
        $selectedStationId = $request->query->get('station', 2);
        $selectedStaion = $stationMeteosRepository->findById($selectedStationId);
        $session = $request->getSession();
        $session->set('selected_station_id', $selectedStationId);
        //dd($session);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $notification->notify($contact);
            $this->addFlash('success', 'Votre message a bien été envoyer');
            return $this->redirectToRoute('home');
        }
        $minimax = $HRepository->findAll();
    	$articles = $this->repotisory->findLatest();
        $alerte = $alerteRepo->findByAlerteTrue();
        $lumiere = $saison->AnimationLumiere($selectedStaion->getStationDirect()->getLumiere());
        $prevision = $saison->previsions($selectedStaion->getStationDirect()->getPression());
        $saison2 = $saison->saison(); 
        $jsonPath = $this->getParameter('kernel.project_dir').'/public/meteo.json';
        $jsonData = file_get_contents($jsonPath);
        $meteo = json_decode($jsonData, true);
         // Récupérer le code météo
        $weatherCode0 = $meteo['forecast'][0]['weather'] ?? null;
        $weatherCode1 = $meteo['forecast'][1]['weather'] ?? null;
        $weatherCode2 = $meteo['forecast'][2]['weather'] ?? null;
        $weatherCode3 = $meteo['forecast'][0]['weather'] ?? null;
         // Liste des icônes associées aux codes météo
         $icons = [
             0 => 'day.svg',
             1 => 'cloudy-day-2.svg',
             2 => 'cloudy-day-1.svg',
             3 => 'cloudy-day-3.svg',
             4 => 'cloudy.svg',
             5 => 'cloudy.svg',
             10 => 'rainy-1.svg',
             11 => 'rainy-1.svg',
             12 => 'rainy-7.svg',
             20 => 'snowy-1.svg',
             21 => 'snowy-5.svg',
             22 => 'snowy-6.svg',
             30 => 'snowy-7.svg',
             31 => 'snowy-7.svg',
             32 => 'snowy-7.svg',
             40 => 'rainy-1.svg',
             41 => 'rainy-5.svg',
             42 => 'rainy-7.svg',
             43 => 'rainy-5.svg',
             44 => 'rainy-6.svg',
             45 => 'rainy-7.svg',
             46 => 'rainy-5.svg',
             47 => 'rainy-6.svg',
             48 => 'rainy-7.svg',
             60 => 'snowy-1.svg',
             61 => 'snowy-2.svg',
             62 => 'snowy-3.svg',
             63 => 'snowy-4.svg',
             64 => 'snowy-5.svg',
             65 => 'snowy-6.svg',
             66 => 'snowy-1.svg',
             67 => 'snowy-2.svg',
             68 => 'snowy-3.svg',
             70 => 'rainy-7.svg',
             71 => 'rainy-7.svg',
             72 => 'rainy-7.svg',
             73 => 'rainy-7.svg',
             74 => 'rainy-7.svg',
             75 => 'rainy-7.svg',
             76 => 'rainy-7.svg',
             77 => 'rainy-7.svg',
             78 => 'rainy-7.svg',
             100 => 'thunder.svg',
             101 => 'thunder.svg',
             102 => 'thunder.svg',
             103 => 'thunder.svg',
             104 => 'thunder.svg',
             105 => 'thunder.svg',

             // Ajoute d'autres codes si nécessaire
         ];
 
         // Déterminer l'icône à afficher
         $weatherIcon = $icons[$weatherCode0] ?? 'default.png';
         $weatherIcon1 = $icons[$weatherCode1] ?? 'default.png';
         $weatherIcon2 = $icons[$weatherCode2] ?? 'default.png';
         $weatherIcon3 = $icons[$weatherCode3] ?? 'default.png';
        return $this->render('station/index.html.twig', [
        	'articles' => $articles,
            'alerte' => $alerte,
            'lumiere' => $lumiere,
            'prevision' => $prevision,
            'minimaxi' => $minimax,
            'form' => $form->createView(),
            'meteo' => $meteo,
            'weatherIcon' => $weatherIcon,
            'weatherIcon1' => $weatherIcon1,
            'weatherIcon2' => $weatherIcon2,
            'weatherIcon3' => $weatherIcon3,
            'Station' => $selectedStaion,
            'stationmeteos' => $stationmeteo,
            'viewStation' => $viewStation,
             
        ]);
    }

    /**
     * @Route("/historique/{station}", name="historique")
     * @param StationRepository $stationrepo
     * @return Response
     */
    public function historique(StationRepository $stationrepo, GrapheNotification $graph, Request $request, MiniMaxiRepository $minimaxirepo, MiniMaxiARepository $mna, $station = null)
    {
           // Si un ID de station est passé, on charge la station
    $selectedStation = null;

    $session = $request->getSession();
    $selectedStaionId = $session->get('selected_station_id', 2);
    if ($session->has('selected_station_id')) {
        $selectedStation = $stationrepo->find($session->get('selected_station_id'));
    }
    
        $station = $stationrepo->findByGraphForStation($selectedStaionId);
        
        $chartT = $graph->temperature($station);
        $chartP = $graph->pression($station);
        $chartH = $graph->humidite($station);
        $chartA = $graph->anemo($station);
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
                'chartTR' => $chartTR,
                'station' => $station,

            ]);
        }
        $minimaxi = $minimaxirepo->findMiniMaxForStation($selectedStaionId);
        $archive_mn = $mna->findByMiniForStation($selectedStaionId);
        //dd($station);
        return $this->render('station/historique.html.twig', [
            'chartT' => $chartT,
            'chartP' => $chartP,
            'chartH' => $chartH,
            'chartA' => $chartA,
            'minimaxi' => $minimaxi,
            'mna' => $archive_mn,
            'form'   => $form->createView(),
            'station' => $station,
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
    public function getStation(Request $request, GetStationNotification $getstation, MiniMaxiNotification $minimax, MiniMaxiANotification $mna, AlerteMeteoNotification $alert)
    {
        $getstation->getStation($request);
        $temp1 = $request->get('temp2');
        $alert->calculAlerteTempAuto($temp1);
        //$mna->minimaxicompare();
        //$minimax->getMinimaxi($request);
        return $this->render('station/essai.html.twig');
    }

    /**
     * @Route("getbddstation", name="getbddstation")
     * @return Response
     */
    public function getBddstation(BddNotification $bdd, OragesNotification $orages, CallApiService $api, VigilanceMeteoFranceNotification $vmf, AlerteMeteoNotification $alert)
    {
        //$twitter->Twitter();
        $orages->getOragesData();
        //$gauges->realTimeGauges(2);
        //$sm->getStationDirect();
        //$bdd->AddBddStation();
        //$vmf->getVigilanceMeteoFrance();
        //$data = $api->getApiMeteoFrance();
        //$data = $api->getApiMeteoConcept();
        //$datacarte = $api->getApiMeteoFranceCarte();
        //$tableau1 = $data['product']['text_bloc_items'][88]['bloc_items'][0]['text_items'][0]['hazard_code'];
        //$tableau2 = $data;
        //dd($data);
        //dd($datacarte['product']['periods'][0]['timelaps']['domain_ids'][46]);
        //$a = "";
        //$alert->vigilanceMeteoFrance();
        return $this->render('station/essai.html.twig');
    }


    /**
     * @Route("getbddminimaxi", name="getbddminimaxi")
     * @return Response
     */
    public function getBddminimaxi(BddNotification $bdd)
    {
        $bdd->AddBddMiniMaxi();
        return $this->render('station/essai.html.twig');
    }

    /**
     * @Route("test", name="test")
     * @param smsNotification $sms
     * @return Response
     */
    public function getTest(smsNotification $sms)
    {

        $sms->alerteSms();


        //$essai = 'salut';
        //$twitter->alerteMeteoTwitter();
        return $this->render('station/essai.html.twig');
    }

    /**
     * @Route("/minimaxihisto", name="minimaxihisto")
     * @param Request $request
     * @return Response
     */
    public function minimaxihisto(MiniMaxiRepository $minimaxi, PaginatorInterface $paginator, Request $request)
    {
        $session = $request->getSession();
        $selectedStaionId = $session->get('selected_station_id', 2);
        $search = new MinimaxiSearch();
        $form = $this->createForm(MinimaxiType::class, $search);
        $form->handleRequest($request);
        $mima = $paginator->paginate($minimaxi->findAllMiniMaxiDesc($search, $selectedStaionId),
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('station/minimaxi.html.twig', [
            'minimaxi' => $mima,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update-realtime-gauges", name="update_realtime_gauges", methods={"POST"})
     * @return Response
     */
    public function updateRealtimeGauges(Request $request, GaugesNotification $gaugesNotification): JsonResponse
    {
        try {
            $stationId = $request->request->get('stationId', 2); // Définit 2 comme valeur par défaut
    
            if (!is_numeric($stationId)) {
                return new JsonResponse(['status' => 'error', 'message' => 'Invalid station ID'], 400);
            }
    
            $gaugesNotification->realTimeGauges((int) $stationId);
    
            return new JsonResponse(['status' => 'success']);
        } catch (\Exception $e) {
            error_log('Error in updateRealtimeGauges: ' . $e->getMessage());
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/json", name="json")
     * @param CallApiService $CallApiService
     * @return Response
     */
    public function index(CallApiService $callApiService): Response
    {
        $standing = $callApiService->getResultVigilances();
        dd($standing["records"][1]["fields"]["daterun"]);
        return new Response($standing["records"][1]["fields"]);
 
    }

}


