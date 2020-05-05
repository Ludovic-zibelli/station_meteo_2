<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
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

    public function __construct(UserRepository $user)
    {

        $this->user = $user;
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
}