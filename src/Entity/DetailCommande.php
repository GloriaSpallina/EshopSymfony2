<?php

namespace App\Entity;

use App\Repository\DetailCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailCommandeRepository::class)
 */
class DetailCommande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="detailsCommande")
     */
    private $commandeRef;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getCommandeRef(): ?Commande
    {
        return $this->commandeRef;
    }

    public function setCommandeRef(?Commande $commandeRef): self
    {
        $this->commandeRef = $commandeRef;

        return $this;
    }

    /**
     * Verification si l'item est déjà présent dans le détail de commande
     * 
     * @param DetailCommande $item
     * 
     * @return bool
     */
    public function doublons(DetailCommande $item): bool
    {
        return $this->getProduit()->getId() === $item->getProduit()->getId();
    
    }

    /**
     * Calculer le total pour chaque ligne de commande
     *
     * @return float|int
     */
    public function getTotalDetailC(): float
    {
        return $this->getProduit()->getPrix() * $this->getQuantite();
    }
}
