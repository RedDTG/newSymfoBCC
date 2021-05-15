<?php

namespace App\Entity;

use App\Repository\EstimationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EstimationRepository::class)
 */
class Estimation
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
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEstimation;

    /**
     * @ORM\ManyToOne(targetEntity=ComissairePriseur::class, inversedBy="estimations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCommissaire;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="estimations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProduit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateEstimation(): ?\DateTimeInterface
    {
        return $this->dateEstimation;
    }

    public function setDateEstimation(\DateTimeInterface $dateEstimation): self
    {
        $this->dateEstimation = $dateEstimation;

        return $this;
    }

    public function getIdCommissaire(): ?ComissairePriseur
    {
        return $this->idCommissaire;
    }

    public function setIdCommissaire(?ComissairePriseur $idCommissaire): self
    {
        $this->idCommissaire = $idCommissaire;

        return $this;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->idProduit;
    }

    public function setIdProduit(?Produit $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }
}
