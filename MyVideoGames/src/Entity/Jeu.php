<?php

namespace App\Entity;

use App\Repository\JeuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuRepository::class)]
class Jeu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Annee = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\ManyToOne(inversedBy: 'jeux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bibliotheque $bibliotheque = null;

    /**
     * @var Collection<int, Showcase>
     */
    #[ORM\ManyToMany(targetEntity: Showcase::class, mappedBy: 'jeux')]
    private Collection $showcases;

    public function __construct()
    {
        $this->showcases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?int
    {
        return $this->Annee;
    }

    public function setAnnee(int $Annee): static
    {
        $this->Annee = $Annee;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getBibliotheque(): ?Bibliotheque
    {
        return $this->bibliotheque;
    }

    public function setBibliotheque(?Bibliotheque $bibliotheque): static
    {
        $this->bibliotheque = $bibliotheque;

        return $this;
    }
    
    public function __toString()
    {
        return $this->getNom();
    }

    /**
     * @return Collection<int, Showcase>
     */
    public function getShowcases(): Collection
    {
        return $this->showcases;
    }

    public function addShowcase(Showcase $showcase): static
    {
        if (!$this->showcases->contains($showcase)) {
            $this->showcases->add($showcase);
            $showcase->addJeux($this);
        }

        return $this;
    }

    public function removeShowcase(Showcase $showcase): static
    {
        if ($this->showcases->removeElement($showcase)) {
            $showcase->removeJeux($this);
        }

        return $this;
    }
}
