<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{

    public function hydrate(array $init)
    {
        foreach ($init as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couleur;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAjoutProduit;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteStock;

    /**
     * @ORM\OneToMany(targetEntity=DetailCommande::class, mappedBy="produit")
     */
    private $detailsCommandes;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="produit")
     */
    private $Evaluations;

    /**
     * @ORM\OneToMany(targetEntity=PhotoProduit::class, mappedBy="produit")
     */
    private $PhotosProduit;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategorie::class, inversedBy="Produits")
     */
    private $sousCategorie;

    public function __construct($arrayInit=[]){
        $this->hydrate($arrayInit);
        $this->detailsCommandes = new ArrayCollection();
        $this->Evaluations = new ArrayCollection();
        $this->PhotosProduit = new ArrayCollection();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getDateAjoutProduit(): ?\DateTimeInterface
    {
        return $this->dateAjoutProduit;
    }

    public function setDateAjoutProduit(\DateTimeInterface $dateAjoutProduit): self
    {
        $this->dateAjoutProduit = $dateAjoutProduit;

        return $this;
    }

    public function getQuantiteStock(): ?int
    {
        return $this->quantiteStock;
    }

    public function setQuantiteStock(int $quantiteStock): self
    {
        $this->quantiteStock = $quantiteStock;

        return $this;
    }

    /**
     * @return Collection|DetailCommande[]
     */
    public function getDetailsCommandes(): Collection
    {
        return $this->detailsCommandes;
    }

    // public function addDetailsCommande(DetailCommande $detailsCommande): self
    // {
    //     if (!$this->detailsCommandes->contains($detailsCommande)) {
    //         $this->detailsCommandes[] = $detailsCommande;
    //         $detailsCommande->setProduit($this);
    //     }

    //     return $this;
    // }

    // public function removeDetailsCommande(DetailCommande $detailsCommande): self
    // {
    //     if ($this->detailsCommandes->removeElement($detailsCommande)) {
    //         // set the owning side to null (unless already changed)
    //         if ($detailsCommande->getProduit() === $this) {
    //             $detailsCommande->setProduit(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection|Evaluation[]
     */
    public function getEvaluations(): Collection
    {
        return $this->Evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): self
    {
        if (!$this->Evaluations->contains($evaluation)) {
            $this->Evaluations[] = $evaluation;
            $evaluation->setProduit($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->Evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getProduit() === $this) {
                $evaluation->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PhotoProduit[]
     */
    public function getPhotosProduit(): Collection
    {
        return $this->PhotosProduit;
    }

    public function addPhotosProduit(PhotoProduit $photosProduit): self
    {
        if (!$this->PhotosProduit->contains($photosProduit)) {
            $this->PhotosProduit[] = $photosProduit;
            $photosProduit->setProduit($this);
        }

        return $this;
    }

    public function removePhotosProduit(PhotoProduit $photosProduit): self
    {
        if ($this->PhotosProduit->removeElement($photosProduit)) {
            // set the owning side to null (unless already changed)
            if ($photosProduit->getProduit() === $this) {
                $photosProduit->setProduit(null);
            }
        }

        return $this;
    }

    public function getSousCategorie(): ?SousCategorie
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?SousCategorie $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }
}
