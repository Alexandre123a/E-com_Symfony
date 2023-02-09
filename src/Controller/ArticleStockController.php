<?php

namespace App\Controller;

use App\Entity\ArticleStock;
use App\Form\ArticleStockType;
use App\Repository\ArticleStockRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/search',name: 'app_article_search', methods: ['GET'])]
    public function ajaxAction(Request $request) {
        $articles = $this->getDoctrine()
            ->getRepository(ArticleStockRepository::class)
            ->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach($articles as $article) {
                $temp = array(
                    'intitule' => $article->getIntitule(),
                    'description' => $article->getDescription(),
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        } else {
            return $this->render('article_stock/ajax.html.twig');
        }
    }
}
