<?php

namespace App\Entity;

use App\Repository\LotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LotRepository::class)
 */
class Lot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixDepart;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVendu;

    /**
     * @ORM\OneToMany(targetEntity=Enchere::class, mappedBy="idLot")
     */
    private $encheres;

    /**
     * @ORM\ManyToOne(targetEntity=Vente::class, inversedBy="lots")
     */
    private $idVente;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="idLot")
     */
    private $produits;

    /**
     * @ORM\ManyToOne(targetEntity=Enchere::class, inversedBy="lots")
     */
    private $bestEnchere;


    public function __construct()
    {
        $this->encheres = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getPrixDepart(): ?float
    {
        return $this->prixDepart;
    }

    public function setPrixDepart(?float $prixDepart): self
    {
        $this->prixDepart = $prixDepart;

        return $this;
    }

    public function getIsVendu(): ?bool
    {
        return $this->isVendu;
    }

    public function setIsVendu(bool $isVendu): self
    {
        $this->isVendu = $isVendu;

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
            $enchere->setIdLot($this);
        }

        return $this;
    }

    public function removeEnchere(Enchere $enchere): self
    {
        if ($this->encheres->removeElement($enchere)) {
            // set the owning side to null (unless already changed)
            if ($enchere->getIdLot() === $this) {
                $enchere->setIdLot(null);
            }
        }

        return $this;
    }

    public function getIdVente(): ?Vente
    {
        return $this->idVente;
    }

    public function setIdVente(?Vente $idVente): self
    {
        $this->idVente = $idVente;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setIdLot($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getIdLot() === $this) {
                $produit->setIdLot(null);
            }
        }

        return $this;
    }

    public function getBestEnchere(): ?Enchere
    {
        return $this->bestEnchere;
    }

    public function setBestEnchere(?Enchere $bestEnchere): self
    {
        $this->bestEnchere = $bestEnchere;

        return $this;
    }

}
