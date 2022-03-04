<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Recruteur::class, inversedBy: 'annonces')]
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

    #[ORM\ManyToMany(targetEntity: Postulant::class, mappedBy: 'annonce')]
    private $postulants;

    public function __construct()
    {
        $this->postulants = new ArrayCollection();
    }

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
            $postulant->addAnnonce($this);
        }

        return $this;
    }

    public function removePostulant(Postulant $postulant): self
    {
        if ($this->postulants->removeElement($postulant)) {
            $postulant->removeAnnonce($this);
        }

        return $this;
    }

    public function checkIfPostulant(Annonce $annonce,Candidat $candidat)
    {
        $postulants = $annonce->getPostulants();
        if(count($postulants)){
            foreach ($postulants as $postulant){
                    return $postulant->getCandidat() == $candidat;
            }
        }
        return true;
    }
}
