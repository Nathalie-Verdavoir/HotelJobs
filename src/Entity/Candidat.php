<?php

namespace App\Entity;

use App\Repository\CandidatRepository;
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

    #[ORM\OneToOne(mappedBy: 'candidat', targetEntity: Postulant::class, cascade: ['persist', 'remove'])]
    private $postulant;

    #[ORM\Column(type: 'boolean')]
    private $actif;

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

    public function getPostulant(): ?Postulant
    {
        return $this->postulant;
    }

    public function setPostulant(Postulant $postulant): self
    {
        // set the owning side of the relation if necessary
        if ($postulant->getCandidat() !== $this) {
            $postulant->setCandidat($this);
        }

        $this->postulant = $postulant;

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
}
