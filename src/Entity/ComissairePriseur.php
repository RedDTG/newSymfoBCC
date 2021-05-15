<?php

namespace App\Entity;

use App\Repository\ComissairePriseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComissairePriseurRepository::class)
 */
class ComissairePriseur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Personne::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idPersonne;

    /**
     * @ORM\OneToMany(targetEntity=Estimation::class, mappedBy="idCommissaire")
     */
    private $estimations;

    public function __construct()
    {
        $this->estimations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPersonne(): ?personne
    {
        return $this->idPersonne;
    }

    public function setIdPersonne(personne $idPersonne): self
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }

    /**
     * @return Collection|Estimation[]
     */
    public function getEstimations(): Collection
    {
        return $this->estimations;
    }

    public function addEstimation(Estimation $estimation): self
    {
        if (!$this->estimations->contains($estimation)) {
            $this->estimations[] = $estimation;
            $estimation->setIdCommissaire($this);
        }

        return $this;
    }

    public function removeEstimation(Estimation $estimation): self
    {
        if ($this->estimations->removeElement($estimation)) {
            // set the owning side to null (unless already changed)
            if ($estimation->getIdCommissaire() === $this) {
                $estimation->setIdCommissaire(null);
            }
        }

        return $this;
    }
}
