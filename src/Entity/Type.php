<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $idCategorie = null;

    #[ORM\OneToMany(mappedBy: 'idType', targetEntity: ArticleStock::class, orphanRemoval: true)]
    private Collection $articleStocks;

    public function __construct()
    {
        $this->articleStocks = new ArrayCollection();
    }

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

    public function getIdCategorie(): ?Categorie
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?Categorie $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    /**
     * @return Collection<int, ArticleStock>
     */
    public function getArticleStocks(): Collection
    {
        return $this->articleStocks;
    }

    public function addArticleStock(ArticleStock $articleStock): self
    {
        if (!$this->articleStocks->contains($articleStock)) {
            $this->articleStocks->add($articleStock);
            $articleStock->setIdType($this);
        }

        return $this;
    }

    public function removeArticleStock(ArticleStock $articleStock): self
    {
        if ($this->articleStocks->removeElement($articleStock)) {
            // set the owning side to null (unless already changed)
            if ($articleStock->getIdType() === $this) {
                $articleStock->setIdType(null);
            }
        }

        return $this;
    }
    public function __toString():string
    {
        return $this->intitule;
    }
}
