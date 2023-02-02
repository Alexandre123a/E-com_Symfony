<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ArticleStock $idStock = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdStock(): ?ArticleStock
    {
        return $this->idStock;
    }

    public function setIdStock(?ArticleStock $idStock): self
    {
        $this->idStock = $idStock;

        return $this;
    }
}
