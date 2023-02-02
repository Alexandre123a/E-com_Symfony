<?php

namespace App\Entity;

use App\Repository\LignePanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LignePanierRepository::class)]
class LignePanier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'lignePaniers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Panier $idPanier = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?ArticleStock $idStock = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPanier(): ?Panier
    {
        return $this->idPanier;
    }

    public function setIdPanier(?Panier $idPanier): self
    {
        $this->idPanier = $idPanier;

        return $this;
    }

    public function getIdStock(): ?ArticleStock
    {
        return $this->idStock;
    }

    public function setIdStock(ArticleStock $idStock): self
    {
        $this->idStock = $idStock;

        return $this;
    }
}
