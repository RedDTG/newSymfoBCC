<?php

namespace App\Entity;

use App\Repository\EnchereRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnchereRepository::class)
 */
class Enchere
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity=Lot::class, inversedBy="encheres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idLot;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $heure;

    /**
     * @ORM\ManyToOne(targetEntity=Acheteur::class, inversedBy="encheres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idAcheteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getIdLot(): ?Lot
    {
        return $this->idLot;
    }

    public function setIdLot(?Lot $idLot): self
    {
        $this->idLot = $idLot;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getIdAcheteur(): ?Acheteur
    {
        return $this->idAcheteur;
    }

    public function setIdAcheteur(?Acheteur $idAcheteur): self
    {
        $this->idAcheteur = $idAcheteur;

        return $this;
    }
}
