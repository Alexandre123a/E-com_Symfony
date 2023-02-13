<?php

namespace App\Controller;

use App\Entity\ArticleStock;
use App\Entity\Categorie;
use App\Entity\Genre;

use App\Entity\Type;
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

    $genre = $request->get("genre");
    $ctg = $request->get("ctg");
    $type = $request->get("type");

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


        $repoType = $doctrine->getRepository(Type::class);
        $repoCatego = $doctrine->getRepository(Categorie::class);
        $repoGenre = $doctrine->getRepository(Genre::class);
        $genres = $repoGenre->findAll();

        if ($ctg != ""){
            $types = $repoType->findByRelation($ctg);
            $categories = $ctg;
        }
        elseif ($genre != "") {


            $categories = $repoCatego->findByRelation($genre);

            foreach ($categories as $ct)
            {

                $types = $repoType->findByRelation($ct->getId());
            }
        }
        else
        {
            $categories = $repoCatego->findAll();
            $types = $repoType->findAll();
        }



        $repository = $doctrine->getRepository(ArticleStock::class);
        $articles = $repository->findByExampleField($name,$range,$order,$type,$ctg,$genre);
        dump($type);
        return $this->render('search/index.html.twig', [
            'searchForm' => $form->createView(),
            'articles' => $articles,
            'name' => $name,
            'genres' => $genres,
            'categories' => $categories,
            'types' => $types

        ]);
    }
    #[Route('ajax/result',methods: ['GET'])]
    public function result(ManagerRegistry $doctrine ,Request $request)
    {
        $name = $request->get("keywords");

        $range = $request->get("range") ?:12;
        $desc = "ASC";
        $order = $request->get("order");

        $genre = $request->get("genre");
        $ctg = $request->get("ctg");
        $type = $request->get("type");

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

        $repoType = $doctrine->getRepository(Type::class);
        $repoCatego = $doctrine->getRepository(Categorie::class);
        $repoGenre = $doctrine->getRepository(Genre::class);
        $genres = $repoGenre->findAll();

        if ($ctg != ""){
            $types = $repoType->findByRelation($ctg);
            $categories = $ctg;
        }
        elseif ($genre != "") {
            $categories = $repoCatego->findByRelation($genre);
            foreach ($categories as $ct)
            {

                $types = $repoType->findByRelation($ct->getId());
            }

        }
        else
        {
            $categories = $repoCatego->findAll();
            $types = $repoType->findAll();
        }
        $repository = $doctrine->getRepository(ArticleStock::class);
        $articles = $repository->findByExampleField($name,$range,$order,$type,$ctg,$genre,$desc);

        return $this->render('search/result.html.twig', [
            'articles' => $articles,
            'genres' => $genres,
            'categories' => $categories,
            'types' => $types

        ]);
    }

    #[Route('/ajax/ctg',methods: ['GET'])]
public function ctgRefresh(ManagerRegistry $doctrine,Request $request)
    {
        $genre = $request->get('genre');
        $repo = $doctrine->getRepository(Categorie::class);
        if($genre) {

            $categories = $repo->findByRelation($genre);
        }
        else{
            $categories = $repo->findAll();
        }
        return $this->render('search/ctg.html.twig',[
            'categories' => $categories,
        ]);
    }
    #[Route('/ajax/types',methods: ['GET'])]
    public function typesRefresh(ManagerRegistry $doctrine,Request $request)
    {
        $ctg = $request->get('ctg');
        $repo = $doctrine->getRepository(Type::class);
        if($ctg) {

            $types = $repo->findByRelation($ctg);
        }
        else{
            $types = $repo->findAll();
        }
        return $this->render('search/ctg.html.twig',[
            'types' => $types,
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
