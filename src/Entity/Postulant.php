<?php

namespace App\Entity;

use App\Repository\PostulantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostulantRepository::class)]
class Postulant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'postulant', targetEntity: Annonce::class, cascade: ['persist', 'remove'])]
    private $annonce;

    #[ORM\OneToOne(inversedBy: 'postulant', targetEntity: Candidat::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $candidat;

    #[ORM\Column(type: 'boolean')]
    private $valide;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnonce(): ?annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getCandidat(): ?candidat
    {
        return $this->candidat;
    }

    public function setCandidat(candidat $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }
}
