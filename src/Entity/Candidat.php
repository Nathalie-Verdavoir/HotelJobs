<?php

namespace App\Entity;

use App\Repository\CandidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatRepository::class)]
class Candidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $userid;

    #[ORM\Column(type: 'string', length: 255)]
    private $cvname;

    #[ORM\Column(type: 'boolean')]
    private $actif;

    #[ORM\ManyToMany(targetEntity: Postulant::class, mappedBy: 'candidat')]
    private $postulants;

    public function __construct()
    {
        $this->postulants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserid(): ?user
    {
        return $this->userid;
    }

    public function setUserid(user $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getCvname(): ?string
    {
        return $this->cvname;
    }

    public function setCvname(string $cvname): self
    {
        $this->cvname = $cvname;

        return $this;
    }
    
    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection<int, Postulant>
     */
    public function getPostulants(): Collection
    {
        return $this->postulants;
    }

    public function addPostulant(Postulant $postulant): self
    {
        if (!$this->postulants->contains($postulant)) {
            $this->postulants[] = $postulant;
            $postulant->addCandidat($this);
        }

        return $this;
    }

    public function removePostulant(Postulant $postulant): self
    {
        if ($this->postulants->removeElement($postulant)) {
            $postulant->removeCandidat($this);
        }

        return $this;
    }
}
