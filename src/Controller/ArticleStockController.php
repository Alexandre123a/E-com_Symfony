<?php

namespace App\Controller;

use App\Entity\ArticleStock;
use App\Entity\LignePanier;
use App\Entity\Panier;
use App\Form\ArticleStockType;
use App\Repository\ArticleStockRepository;
use App\Repository\LignePanierRepository;
use App\Repository\PanierRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/article/stock')]
class ArticleStockController extends AbstractController
{
    #[Route('/', name: 'app_article_stock_index', methods: ['GET'])]
    public function index(ArticleStockRepository $articleStockRepository): Response
    {
        return $this->render('article_stock/index.html.twig', [
            'article_stocks' => $articleStockRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_stock_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleStockRepository $articleStockRepository): Response
    {
        $articleStock = new ArticleStock();
        $form = $this->createForm(ArticleStockType::class, $articleStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleStockRepository->save($articleStock, true);

            return $this->redirectToRoute('app_article_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article_stock/new.html.twig', [
            'article_stock' => $articleStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_stock_show', methods: ['GET'])]
    public function show(ArticleStock $articleStock): Response
    {
        return $this->render('article_stock/show.html.twig', [
            'article_stock' => $articleStock,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_stock_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ArticleStock $articleStock, ArticleStockRepository $articleStockRepository): Response
    {
        $form = $this->createForm(ArticleStockType::class, $articleStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleStockRepository->save($articleStock, true);

            return $this->redirectToRoute('app_article_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article_stock/edit.html.twig', [
            'article_stock' => $articleStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_stock_delete', methods: ['POST'])]
    public function delete(Request $request, ArticleStock $articleStock, ArticleStockRepository $articleStockRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articleStock->getId(), $request->request->get('_token'))) {
            $articleStockRepository->remove($articleStock, true);
        }

        return $this->redirectToRoute('app_article_stock_index', [], Response::HTTP_SEE_OTHER);
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
        return new Response("Ajout avec succès");
    }
}
