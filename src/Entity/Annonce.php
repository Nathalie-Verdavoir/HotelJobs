<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: recruteur::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private $recruteur;

    #[ORM\Column(type: 'string', length: 255)]
    private $intitule;

    #[ORM\Column(type: 'string', length: 255)]
    private $lieu;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'boolean')]
    private $visible;

    #[ORM\OneToOne(mappedBy: 'annonce', targetEntity: Postulant::class, cascade: ['persist', 'remove'])]
    private $postulant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecruteur(): ?recruteur
    {
        return $this->recruteur;
    }

    public function setRecruteur(?recruteur $recruteur): self
    {
        $this->recruteur = $recruteur;

        return $this;
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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getPostulant(): ?Postulant
    {
        return $this->postulant;
    }

    public function setPostulant(?Postulant $postulant): self
    {
        // unset the owning side of the relation if necessary
        if ($postulant === null && $this->postulant !== null) {
            $this->postulant->setAnnonce(null);
        }

        // set the owning side of the relation if necessary
        if ($postulant !== null && $postulant->getAnnonce() !== $this) {
            $postulant->setAnnonce($this);
        }

        $this->postulant = $postulant;

        return $this;
    }
}
