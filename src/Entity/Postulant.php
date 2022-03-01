<?php

namespace App\Entity;

use App\Repository\PostulantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostulantRepository::class)]
class Postulant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $valide;

    #[ORM\ManyToMany(targetEntity: Candidat::class, inversedBy: 'postulants')]
    private $candidat;

    #[ORM\ManyToMany(targetEntity: Annonce::class, inversedBy: 'postulants')]
    private $annonce;

    public function __construct()
    {
        $this->candidat = new ArrayCollection();
        $this->annonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Candidat>
     */
    public function getCandidat(): Collection
    {
        return $this->candidat;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidat->contains($candidat)) {
            $this->candidat[] = $candidat;
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        $this->candidat->removeElement($candidat);

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonce(): Collection
    {
        return $this->annonce;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonce->contains($annonce)) {
            $this->annonce[] = $annonce;
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        $this->annonce->removeElement($annonce);

        return $this;
    }
}
