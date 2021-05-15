<?php

namespace App\Entity;

use App\Repository\AcheteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AcheteurRepository::class)
 */
class Acheteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSolvable;

    /**
     * @ORM\OneToMany(targetEntity=Enchere::class, mappedBy="idAcheteur")
     */
    private $encheres;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, cascade={"persist", "remove"})
     */
    private $idUtilisateur;

    public function __construct()
    {
        $this->encheres = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getIdUtilisateur()->getIdPersonne()->getEmail();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsSolvable(): ?bool
    {
        return $this->isSolvable;
    }

    public function setIsSolvable(bool $isSolvable): self
    {
        $this->isSolvable = $isSolvable;

        return $this;
    }

    /**
     * @return Collection|Enchere[]
     */
    public function getEncheres(): Collection
    {
        return $this->encheres;
    }

    public function addEnchere(Enchere $enchere): self
    {
        if (!$this->encheres->contains($enchere)) {
            $this->encheres[] = $enchere;
            $enchere->setIdAcheteur($this);
        }

        return $this;
    }

    public function removeEnchere(Enchere $enchere): self
    {
        if ($this->encheres->removeElement($enchere)) {
            // set the owning side to null (unless already changed)
            if ($enchere->getIdAcheteur() === $this) {
                $enchere->setIdAcheteur(null);
            }
        }

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }
}
