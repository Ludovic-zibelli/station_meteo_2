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

    public function admin(Request $request, AlertMeteoRepository $repo_alert, AlerteMeteoNotification $notif)
    {
        $alerte = new AlertMeteo();
        $form = $this->createForm(AlerteMeteoType::class, $alerte);
        $form->handleRequest($request);
        $heure = date("H:i");
        $alertRepo = $repo_alert->findByAlerteAll();
        if($form->isSubmitted() && $form->isValid())
        {
            $alerte->setType(true);
            $this->em->persist($alerte);
            $this->em->flush();
            $this->addFlash('success', 'Alerte Météo Manuel ajouter');
            $notif->alerteTwitter();
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/admin.html.twig',[
            'heure' => $heure,
            'alerterepo' => $alertRepo,
            'form' => $form->createView()
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
        $stationmeteo = $this->stationmeteo->find($id);
        return $this->render('admin/stationview.html.twig',[
            'stationmeteo' => $stationmeteo
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
}