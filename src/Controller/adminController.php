<?php

namespace App\Controller;


use App\Entity\AlertMeteo;
use App\Entity\User;
use App\Form\AlerteMeteoType;
use App\Form\UserType;
use App\Notification\AlerteMeteoNotification;
use App\Repository\AlertMeteoRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArcticlesRepository;
use App\Repository\CategoryRepository;
use App\Entity\Arcticles;
use App\Entity\Category;
use App\Entity\Station;
use App\Entity\StationMeteos;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Form\StationMeteosType;
use App\Repository\StationMeteosRepository;
use MapUx\Builder\MapBuilder;
use MapUx\Model\Marker;
use MapUx\Model\Popup;
use MapUx\Model\Icon;
use App\Controller\TripleZoomMap;
use App\Entity\Orages;
use App\Repository\StationDirectRepository;
use App\Repository\VigilanceMeteofranceRepository;
use App\Notification\CallApiService;
use App\Notification\OragesNotification;
use App\Notification\VigilanceMeteoFranceNotification;
use App\Repository\OragesRepository;
use App\Repository\SiteConfigRepository;

class adminController extends AbstractController
{

    /**
     * @var User
     */
    private $user;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var stationmeteo
     */
    private $stationmeteo;
   

    public function __construct(UserRepository $user, EntityManagerInterface $em, StationMeteosRepository $stationmeteo)
    {

        $this->user = $user;
        $this->em = $em;
        $this->stationmeteo = $stationmeteo;
        
    }

    /**
     * @Route("/admin", name="admin")
     * @param Request $request
     * @return Response
     */

    public function admin(Request $request, AlertMeteoRepository $repo_alert, AlerteMeteoNotification $notif, VigilanceMeteofranceRepository $vigilance, OragesRepository $orages, SiteConfigRepository $siteConfig)
    {
        $session = $request->getSession();
        $maintenance = $siteConfig->findOneBy([]);
        $alertRepo = $repo_alert->findByAlerteTrue();
        $vigilance = $vigilance->findAll();
        $orages = $orages->findAll();
        return $this->render('admin/admin.html.twig',[
            
            'alerterepo' => $alertRepo,
            'vigilance' => $vigilance,
            'orages' => $orages,
            'maintenance' => $maintenance->getMaintenance(),
            'date_time_main' => $maintenance->getDateTimeMain(),
            'view_station' => $maintenance->getViewStation(),
            'date_time_view' => $maintenance->getDateTimeView(),
            
            ]);
    }

    /**
     * @Route("/admin/user", name="user")
     * @param Request $request
     * @return Response
     */
    public function user()
    {
        $user = $this->user->findAll();
        return $this->render('admin/user.html.twig',[
            'user' => $user
        ]);
    }


    /**
     * @Route("/admin/adduser", name="admin.user.add")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passencod
     * @return Response
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $passencod)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $password = $passencod->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur ajouter avec succés');
            return $this->redirectToRoute('user');
        }
        return $this->render('admin/useradd.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/useredit/{id}", name="admin.user.edit", methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $pass
     * @return Response
     */
    public function editUser(User $user, Request $request, UserPasswordEncoderInterface $pass)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $passowrd = $pass->encodePassword($user, $user->getPassword());
            $user->setPassword($passowrd);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur modifer avec succés');
            return $this->redirectToRoute('user');
        }
        return $this->render('admin/useredit.html.twig',[
           'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/userdelete/{id}", name="admin.user.delete", methods="DELETE")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function deleteUser(User $user, Request $request)
    {
        if($this->isCsrfTokenValid('delete'. $user->getId(), $request->get('_token')))
        {
            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur supprimer avec succés');
        }

        return $this->redirectToRoute('user');

    }

    /**
     * @Route("/admin/gestionstation", name="gestionstation")
     * @param Request $request
     * @return Response
     */
    public function gestionStations()
    {
        $stationmeteo = $this->stationmeteo->findAll();
        //dd($stationmeteo);
        return $this->render('admin/gestion_station.html.twig',[
            'station' => $stationmeteo
            ]);
    }

    /**
     * @Route("/admin/addstation", name="addstation")
     * @param Request $request
     * @return Response
     */
    public function addStations(Request $request)
    {
        
        $station = new StationMeteos();
        $form = $this->createForm(StationMeteosType :: class, $station);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($station);
            $this->em->flush();
            $this->addFlash('success', 'Station ajouter avec succes');
            return $this->redirectToRoute('gestionstation');
        }
        return $this->render('admin/station_add.html.twig',[
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/admin/stationedit/{id}", name="admin.stationmeteos.edit", methods="GET|POST")
     * @param StationMeteos $stationMeteos
     * @param Request $request
     * @return Response
     */
    public function editStation(StationMeteos $stationMeteos, Request $request)
    {
        $form = $this->createForm(StationMeteosType::class, $stationMeteos);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Station modifer avec succés');
            return $this->redirectToRoute('gestionstation');
        }
        return $this->render('admin/stationmeteosedit.html.twig',[
            'stationmeteos' => $stationMeteos,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/stationdelete/{id}", name="admin.stationmeteo.delete", methods="DELETE")
     * @param StationMeteos $stationMeteos
     * @param Request $request
     * @return Response
     */
    public function deleteStation(StationMeteos $stationMeteos, Request $request)
    {
        if($this->isCsrfTokenValid('delete'. $stationMeteos->getId(), $request->get('_token')))
        {
            $this->em->remove($stationMeteos);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur supprimer avec succés');
        }

        return $this->redirectToRoute('gestionstation');

    }

    /**
     * @Route("/stationmeteo/{id}", name="station.show")
     * @param Request $request
     * @return Response
     */
    public function showStation($id)
    {
        $mapBuilder = new MapBuilder();
        $map = $mapBuilder->createMap(44.00, -0.57, 10);
        $marker = new Marker();
        $icon = new Icon('red');
        $marker->setIcon($icon);
        $map->addMarker($marker);

     
        $stationmeteo = $this->stationmeteo->find($id);
        return $this->render('admin/stationview.html.twig',[
            'stationmeteo' => $stationmeteo,
            'map' => $map
        ]);
    }

    /**
     * @Route("/admin/alerteedit/{id}", name="admin.alerte.edit", methods="GET|POST")
     * @param AlertMeteo $alerte
     * @param Request $request
     * @return Response
     */
    public function editAlerte(AlertMeteo $alerte, Request $request)
    {
        $form = $this->createForm(AlerteMeteoType::class, $alerte);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $this->em->flush();
            $this->addFlash('success', 'Utilisateur modifer avec succés');
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/alerteedit.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/alertedelete/{id}", name="admin.alerte.delete", methods="DELETE")
     * @param AlertMeteo $alerte
     * @param Request $request
     * @return Response
     */
    public function deleteAlerte(AlertMeteo $alerte, Request $request)
    {
        if($this->isCsrfTokenValid('delete'. $alerte->getId(), $request->get('_token')))
        {
            $this->em->remove($alerte);
            $this->em->flush();
            $this->addFlash('success', 'Alerte supprimer avec succés');
        }

        return $this->redirectToRoute('admin');

    }

    //Page alertes meteo
        /**
     * @Route("/admin/alertemeteo", name="alertemeteo")
     * @param Request $request
     * @return Response
     */
    public function alerteMeteo(Request $request, AlertMeteoRepository $repo_alert, AlerteMeteoNotification $notif, VigilanceMeteofranceRepository $vigilance)
    {
        
        $alerte = new AlertMeteo();
        $form = $this->createForm(AlerteMeteoType::class, $alerte);
        $form->handleRequest($request);
        $heure = date("H:i");
        $alertRepo = $repo_alert->findByAlerteAll();
        $vigilance = $vigilance->findAll();
        if($form->isSubmitted() && $form->isValid())
        {
            $alerte->setType(true);
            $this->em->persist($alerte);
            $this->em->flush();
            $this->addFlash('success', 'Alerte Météo Manuel ajouter');
            $notif->alerteTwitter();
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/alerte_meteo.html.twig',[
            'heure' => $heure,
            'alerterepo' => $alertRepo,
            'vigilance' => $vigilance,
            'form' => $form->createView()
            ]);
        
    }

    
    //Acce a la page gestion API
    /**
     * @Route("/admin/apigestion", name="admin.apigestion")
     * @param Request $request
     * @return Response
     */
    public function apiGestion(VigilanceMeteofranceRepository $vigilance, StationDirectRepository $stationDirect, OragesRepository $orages)
    {
       
        $vigilance2 = $vigilance->findAll();
        $stationDirect = $stationDirect->findAll();
        $orages = $orages->findAll();
        $jsonPath = $this->getParameter('kernel.project_dir').'/public/meteo.json';
        $jsonData = file_get_contents($jsonPath);
        $meteo = json_decode($jsonData, true);
        return $this->render('admin/gestion_api.html.twig',[
            'vigilance' => $vigilance2,
            'meteo' => $meteo,
            'stationDirect' => $stationDirect,
            'orages' => $orages
        ]);

    }

        //Acce a la page gestion API
    /**
     * @Route("/admin/refrechmf", name="admin.refrechmf")
     * @param Request $request
     * @return Response
     */
    public function refrechMf(VigilanceMeteoFranceNotification $vigilance)
    {
        try {
            $vigilance->getVigilanceMeteoFrance();
            $this->addFlash('success', 'Vigilance Météo France actualisée avec succès.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'actualisation : ' . $e->getMessage());
        }
        //$vigilance->getVigilanceMeteoFrance();
        //$this->addFlash('success', 'Vigilance Météo France actualiser');
        return $this->redirectToRoute('admin.apigestion');
   
    }

    //Acce a la page gestion API
    /**
     * @Route("/admin/refrechorages", name="admin.refrechorages")
     * @param Request $request
     * @return Response
     */
    public function refrechOrages(OragesNotification $orages)
    {
        try {
            $orages->getOragesData();
            $this->addFlash('success', 'Vigilance Météo France actualisée avec succès.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'actualisation : ' . $e->getMessage());
        }
       
        return $this->redirectToRoute('admin.apigestion');
   
    }

      /**
     * @Route("/admin/refrechmc", name="admin.refrechmc")
     * @param Request $request
     * @return Response
     */
    public function refrechMC(CallApiService $getmeteo)
    {
        $getmeteo->getApiMeteoConcept();
        $this->addFlash('success', 'Météo Concept actualiser');
        return $this->redirectToRoute('admin.apigestion');
   
    }

    
    //Acce a la page gestion API
    /**
     * @Route("/admin/infobdd", name="admin.infobdd")
     * @param Request $request
     * @return Response
     */
    public function infoBDD()
    {
       
        $connection = $this->em->getConnection();
        // Récupérer la taille de la base
        $sqlSize = "SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS taille FROM information_schema.tables WHERE table_schema = 'station_meteo_2'";
        $stmtSize = $connection->executeQuery($sqlSize);
        $tailleBase = $stmtSize->fetchOne();

        $tables = [
            'station',
            'alert_meteo',
            'arcticles',
            'commentaires',
            'station_meteos',
            'mini_maxi',
            'user'
        ];
        
        $rowCounts = [];
        foreach ($tables as $table) {
            $sql = "SELECT COUNT(*) FROM $table";
            $stmt = $connection->executeQuery($sql);
            $rowCounts[$table] = $stmt->fetchOne();
        }
        
        return $this->render('admin/infobdd.html.twig', [
            'tailleBase' => $tailleBase,
            'rowCounts' => $rowCounts
        ]);
        
    }

    /**
     * @Route("/admin/maintenance", name="admin.maintenance", methods={"POST"})
    */
    // Exemple d'action pour activer la maintenance
    public function toggleMaintenance(SiteConfigRepository $siteConfig)
    {
        $config = $siteConfig->findOneBy([]);
        $config->setMaintenance(!$config->getMaintenance());
        $config->setDateTimeMain(new \DateTime());
        $this->em->flush();
        return $this->redirectToRoute('admin');
    }

    
    /**
     * @Route("/admin/view", name="admin.view", methods={"POST"})
    */
    // Idem pour viewStation
    public function toggleViewStation(SiteConfigRepository $siteConfig)
    {
        $config = $siteConfig->findOneBy([]);
        $config->setViewStation(!$config->getViewStation());
        $config->setDateTimeView(new \DateTime());
        $this->em->flush();
        return $this->redirectToRoute('admin');
    }

}