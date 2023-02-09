<?php

namespace App\Controller;

use App\Repository\ArticleStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Acceuil extends AbstractController
{
    #[Route('/')]
    public function number(ArticleStockRepository $articleStockRepository):Response
    {
        $number = random_int(0,100);
        $article =$articleStockRepository->findTenByRandom();

        return $this->render('Acceuil.html.twig', [
            'number' => $number,
            'articles' => $article,
        ]);
    }

}