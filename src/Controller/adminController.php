<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
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
use App\Form\ArticleType;
use App\Form\CategoryType;




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

    public function __construct(UserRepository $user, EntityManagerInterface $em)
    {

        $this->user = $user;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin")
     * @param Request $request
     * @return Response
     */

    public function admin()
    {
        return $this->render('admin/admin.html.twig');
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
}