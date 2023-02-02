<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    #[ORM\OneToMany(mappedBy: 'idMarque', targetEntity: ArticleStock::class)]
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
            $articleStock->setIdMarque($this);
        }

        return $this;
    }

    public function removeArticleStock(ArticleStock $articleStock): self
    {
        if ($this->articleStocks->removeElement($articleStock)) {
            // set the owning side to null (unless already changed)
            if ($articleStock->getIdMarque() === $this) {
                $articleStock->setIdMarque(null);
            }
        }

        return $this;
    }
}
