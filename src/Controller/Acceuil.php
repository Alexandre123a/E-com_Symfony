<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Acceuil extends AbstractController
{
    #[Route('/')]
    public function number():Response
    {
        $number = random_int(0,100);
        return $this->render('Acceuil.html.twig', [
            'number' => $number,
        ]);
    }

}