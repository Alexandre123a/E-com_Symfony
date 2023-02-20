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
            $totalPrice += $article->getPrix() * $lignearticle->getQuantity();
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
    $item = $articleStockRepository->findOneByID($itemID);

    $idPanier = $panier->getId();
    $lignePanier = $lignePanierRepository->findOneByArticleStockAndByIdCart($itemID,$idPanier);

    $lignePanier->addQuantity();
    $entityManager->persist($lignePanier);
    $entityManager->flush();
    $return= [];
    $return["quantity"]=$lignePanier->getQuantity();
    $return[]= "Ajout avec succès";
    $return[]= $item->getPrix();


    return new Response(json_encode($return));
}
    #[Route('/del/panier', methods: ['GET'])]
    public function delOfCart(ManagerRegistry $doctrine,Request $request,UserInterface $user,EntityManagerInterface $entityManager,PanierRepository $panierRepository,ArticleStockRepository $articleStockRepository,LignePanierRepository $lignePanierRepository)
    {
        $itemID = $request->get('id');

        $idUser = $user->getID();
        $panier = $panierRepository->findByUserID($idUser);
        $item = $articleStockRepository->findOneByID($itemID);
        $lignePanier = $lignePanierRepository->findOneByArticleStockAndByIdCart($itemID,$panier->getId());
        $return = [];
        $lignePanier->subQuantity();
        if ($lignePanier->getQuantity() <=0)
        {
            $lignePanierRepository->remove($lignePanier,true);
            $return["del"] = "Article retiré du panier";

        }
        else {
            $entityManager->persist($lignePanier);
            $entityManager->flush();
            $return["quantity"]=$lignePanier->getQuantity();
            $return[]= "Retrait avec succès";
            $return[]= $item->getPrix();
        }
        return new Response(json_encode($return));


    }


}
