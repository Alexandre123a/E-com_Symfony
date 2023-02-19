<?php

namespace App\Controller;

use App\Entity\LignePanier;
use App\Entity\Panier;
use App\Repository\ArticleStockRepository;
use App\Repository\LignePanierRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Encoder\JsonEncode;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_cart')]
public function show(UserInterface $user,PanierRepository $panierRepo,ArticleStockRepository $articleRepo):Response
    {
        $panier = $panierRepo->findByUserID($user->getId());
        if ($panier == null) {
            $panier = new Panier();
            $panier->setIdUser($user);
        }
        $lignearticles = $panier->getLignePaniers();
        $totalPrice = 0;
        $listArticle = [];
        foreach ($lignearticles as $lignearticle) {
            $article = $articleRepo->find($lignearticle->getIdStock());
            $listArticle[] = ['article' => $article, 'quantity' => $lignearticle->getQuantity()];
            $totalPrice += $article->getPrix();
        }


        return $this->render('panier/index.html.twig', [
            'prix' => $totalPrice,
            'articles' => $listArticle

        ]);
    }
    #[Route('/add/panier', methods: ['GET'])]
    public function addToCart(ManagerRegistry $doctrine,Request $request,UserInterface $user,EntityManagerInterface $entityManager,PanierRepository $panierRepository,ArticleStockRepository $articleStockRepository,LignePanierRepository $lignePanierRepository) {
    $itemID  = $request->get('id');

    $idUser= $user->getID();
    $panier = $panierRepository->findByUserID($idUser);
    if ($panier == null){
        $panier=new Panier();
        $panier->setIdUser($user);
        $entityManager->persist($panier);

    }



    $item = $articleStockRepository->findOneByID($itemID);
    $lignePanier = $lignePanierRepository->findOneByArticleStock($itemID);
    if ($lignePanier == null) {
        $lignePanier = new LignePanier();
        $lignePanier->setIdPanier($panier);
        $lignePanier->setIdStock($item);
    }
    $lignePanier->addQuantity();
    $entityManager->persist($lignePanier);
    $entityManager->flush();
    $return= [];
    $return["quantity"]=$lignePanier->getQuantity();
    $return[]= "Ajout avec succès";
    $return[]= $item->getPrix();


    return new Response(json_encode($return));
}

}
