<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCommande;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=DetailCommande::class, mappedBy="commandeRef")
     */
    private $detailsCommande;

    /**
     * @ORM\ManyToOne(targetEntity=AdresseLivraison::class, inversedBy="commandes")
     */
    private $AdresseLivraison;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Commandes")
     */
    private $user;

  

    public function __construct()
    {
        $this->detailsCommande = new ArrayCollection();
     
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|DetailCommande[]
     */
    public function getDetailsCommande(): Collection
    {
        return $this->detailsCommande;
    }

    public function addDetailsCommande(DetailCommande $detailsCommande): self
    {
        if (!$this->detailsCommande->contains($detailsCommande)) {
            $this->detailsCommande[] = $detailsCommande;
            $detailsCommande->setCommandeRef($this);
        }

        return $this;
    }

    public function removeDetailsCommande(DetailCommande $detailsCommande): self
    {
        if ($this->detailsCommande->removeElement($detailsCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailsCommande->getCommandeRef() === $this) {
                $detailsCommande->setCommandeRef(null);
            }
        }

        return $this;
    }

    public function getAdresseLivraison(): ?AdresseLivraison
    {
        return $this->AdresseLivraison;
    }

    public function setAdresseLivraison(?AdresseLivraison $AdresseLivraison): self
    {
        $this->AdresseLivraison = $AdresseLivraison;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
    * Calculer le total de la commande
    *
    * @return float
    */
    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getDetailsCommande() as $item) {
            $total += $item->getTotalDetailC();
        }

        return $total;
    }
}
