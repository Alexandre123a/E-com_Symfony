<?php

namespace App\Controller;

use App\Entity\ArticleStock;
use App\Entity\SearchPOO;
use App\Form\SearchForm;
use App\Repository\ArticleStockRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{

    #[Route('/search', name: 'app_search',methods: ['GET'])]
    public function index(ManagerRegistry $doctrine, Request $request):Response
    {
        $form = $this->createForm(SearchForm::class);

        $name = $request->get("keywords");

        $range = $request->get("range") ?:12;

        $repository = $doctrine->getRepository(ArticleStock::class);
        $articles = $repository->findByExampleField($name,$range);



        return $this->render('search/index.html.twig', [
            'searchForm' => $form->createView(),
            'articles' => $articles,
            'name' => $name,

        ]);

    }
    #[Route('ajax/search', name: 'app_ajax_search')]
public function search(ManagerRegistry $doctrine,Request $request)
    {
        $form = $this->createForm(SearchForm::class);

        $name = $request->get("keywords");

        $range = $request->get("range") ?:12;

        $repository = $doctrine->getRepository(ArticleStock::class);
        $articles = $repository->findByExampleField($name,$range);

        return $this->render('search/index.html.twig', [
            'searchForm' => $form->createView(),
            'articles' => $articles,
            'name' => $name,

        ]);
    }
    #[Route('ajax/result',methods: ['GET'])]
    public function result(ManagerRegistry $doctrine ,Request $request)
    {
        $name = $request->get("keywords");

        $range = $request->get("range") ?:12;

        $repository = $doctrine->getRepository(ArticleStock::class);
        $articles = $repository->findByExampleField($name,$range);

        return $this->render('search/result.html.twig', [
            'articles' => $articles,

        ]);
    }

    /*
    #[Route('/search', name: 'app_search')]
    public function founction(ManagerRegistry $doctrine): Response
    {
        $article = $doctrine->getRepository(ArticleStock::class)->findAll();
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'articles' => $article,

        ]);
    }*/
}
