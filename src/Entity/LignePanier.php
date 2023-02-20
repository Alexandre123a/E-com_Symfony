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

    #[ORM\OneToOne(targetEntity: "articleStock",cascade: ['remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?ArticleStock $idStock = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
    public function addQuantity():self
    {
        $this->quantity +=1;
        return $this;
    }
    public function subQuantity():self
    {
        $this->quantity -=1;
        return $this;
    }
}
