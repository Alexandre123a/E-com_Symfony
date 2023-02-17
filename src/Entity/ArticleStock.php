<?php

namespace App\Entity;

use App\Repository\ArticleStockRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Response;

#[ORM\Entity(repositoryClass: ArticleStockRepository::class)]
class ArticleStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column(length: 4096, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'articleStocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $idType = null;

    #[ORM\ManyToOne(inversedBy: 'articleStocks')]
    private ?Marque $idMarque = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdType(): ?Type
    {
        return $this->idType;
    }

    public function setIdType(?Type $idType): self
    {
        $this->idType = $idType;

        return $this;
    }

    public function getIdMarque(): ?Marque
    {
        return $this->idMarque;
    }

    public function setIdMarque(?Marque $idMarque): self
    {
        $this->idMarque = $idMarque;

        return $this;
    }

    #[Route('/article/stock/{id}', name: 'app_article_stock')]
    public function show(ManagerRegistry $doctrine,int $id):Response
    {
        $article = $doctrine->getRepository(ArticleStock::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Pas d\'article pour cet ID'.$id
            );
        }
        return $this->render('article_stock/articleById.html.twig', ['product'=>$article]);
    }
}
