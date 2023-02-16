<?php

namespace App\Controller;

use App\Repository\ArticleStockRepository;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(): Response
    {
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }
    #[Route('/panier', name: 'app_cart')]
public function show(UserInterface $user,PanierRepository $panierRepo,ArticleStockRepository $articleRepo):Response
{
    $panier = $panierRepo->findByUserID($user->getId());
    $lignearticles = $panier->getLignePaniers();
    $totalPrice=0;
    $listArticle= [];
    foreach ($lignearticles as $lignearticle)
    {
        $article = $articleRepo->find($lignearticle->getIdStock());
$listArticle[] = $article;
        $totalPrice += $article->getPrix();
    }


    return $this->render('panier/index.html.twig',[
        'prix' => $totalPrice,
        'listArticle' => $listArticle,

    ]);
}
}
