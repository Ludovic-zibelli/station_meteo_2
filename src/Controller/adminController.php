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
use App\Repository\CategoryRepository;
use App\Entity\Arcticles;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;




class adminController extends AbstractController
{

	/**
	*@var ArcticlesRepository
	*/
	private $repotisory;

	/**
	*@var CategoryRepository
	*/
	private $repocat;

	/**
	*@var EntityManagerInterface
	*/
	private $em;


	public function __construct(ArcticlesRepository $repotisory, CategoryRepository $repocat, EntityManagerInterface $em)
	{
		$this->repotisory = $repotisory;
		$this->repocat = $repocat;
		$this->em = $em;
		
		
	}


	/**
     * @Route("/adminarticle", name="admin.article")
     * @param Request $request
     * @return Response
     */
	public function admin()
	{
		$articles = $this->repotisory->findAll();
        return $this->render('admin/admin_article.html.twig',[
        	'articles' => $articles
        ]);
	}

	/**
     * @Route("/adminarticle/edit/{id}", name="admin.articles.edit", methods="GET|POST")
     * @param Request $request
     * @param Arcticles $article
     * @return Response
     */
	public function edit(Arcticles $article, Request $request)
	{
		
		$form = $this->createForm(ArticleType::class, $article);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->flush();
			$this->addFlash('success', 'Article modifier avec succès');
			return $this->redirectToRoute('admin.article');
		}
        return $this->render('admin/article_edit.html.twig',[
        	'article' => $article,
        	'form'    => $form->createView()
        ]);
	}

	/**
     * @Route("/adminarticle/add", name="admin.articles.add")
     * @param Request $request
     * @param Arcticles $article
     * @return Response
     */
	public function add(Request $request)
	{
		$article = new Arcticles();
		$form = $this->createForm(ArticleType::class, $article);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->persist($article);
			$this->em->flush();
			$this->addFlash('success', 'Article crée avec succès');
			return $this->redirectToRoute('admin.article');
		}
		return $this->render('admin/article_add.html.twig',[
			'form' => $form->createView()
		]);
	}

	/**
     * @Route("/adminarticle/category", name="admin.articles.category")
     * @param Request $request
     * @param Category $category
     * @return Response
     */
	public function category(Request $request)
	{
		$category = new Category();
		
		$form = $this->createForm(CategoryType::class, $category);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			$this->em->persist($category);
			$this->em->flush();
			$this->addFlash('success', 'Categorie ajouter avec succès');
			return $this->redirectToRoute('admin.articles.category');
		}
		$category_1 = $this->repocat->findAll();
		return $this->render('admin/article_category.html.twig',[
			'form' => $form->createView(),
			'category' => $category_1
		]);
	}

	/**
     * @Route("/adminarticle/delete/{id}", name="admin.articles.delete", methods="DELETE")
     * @param Request $request
     * @param Arcticles $article
     * @return Response
     */
	public function delete(Arcticles $article, Request $request)
	{
		if($this->isCsrfTokenValid('delete'. $article->getId(), $request->get('_token')))
		{
			$this->em->remove($article);
			$this->em->flush();
			$this->addFlash('success', 'Article supprimer avec succès');
			
		}
		return $this->redirectToRoute('admin.article');	
	}

	/**
     * @Route("/adminarticle/deletecategory/{id}", name="admin.articles.deletecategory", methods="DELETE")
     * @param Request $request
     * @param Arcticles $article
     * @return Response
     */
	public function deleteCategory(Category $category, Request $request)
	{
		if($this->isCsrfTokenValid('delete'. $category->getId(), $request->get('_token')))
		{
			$this->em->remove($category);
			$this->em->flush();
			$this->addFlash('success', 'Categorie supprimer avec succès');
			
		}
		return $this->redirectToRoute('admin.articles.category');	
	}
}