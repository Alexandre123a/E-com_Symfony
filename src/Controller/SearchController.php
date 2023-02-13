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
    $order = $request->get("order");

        switch ($order){
            case "Default":
                $order = "a.id";
                break;
            case "Price_ASC":
                $order = "a.prix";
                break;
            case "Price_DESC":
                $order = "a.prix";
                $desc = "DESC";
                break;
            case "New":
                $order = "a.id";
                $desc = "DESC";
                break;
            default:
                $order = "a.id";
        }

        $repository = $doctrine->getRepository(ArticleStock::class);
        $articles = $repository->findByExampleField($name,$range,$order);

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
        $desc = "ASC";
        $order = $request->get("order");
        switch ($order){
            case "Default":
                $order = "a.id";
                break;
            case "Price_ASC":
                $order = "a.prix";
                break;
            case "Price_DESC":
                $order = "a.prix";
                $desc = "DESC";
                break;
            case "New":
                $order = "a.id";
                $desc = "DESC";
                break;
        }


        $repository = $doctrine->getRepository(ArticleStock::class);
        $articles = $repository->findByExampleField($name,$range,$order,$desc);

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
