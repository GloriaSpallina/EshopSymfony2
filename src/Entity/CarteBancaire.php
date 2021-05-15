<?php

namespace App\Entity;

use App\Repository\CarteBancaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarteBancaireRepository::class)
 */
class CarteBancaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     */
    private $numeroCarte;

    /**
     * @ORM\Column(type="bigint")
     */
    private $numeroCompte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titulaire;

    /**
     * @ORM\Column(type="date")
     */
    private $dateExpiration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeMoyen;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Cartes")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCarte(): ?string
    {
        return $this->numeroCarte;
    }

    public function setNumeroCarte(string $numeroCarte): self
    {
        $this->numeroCarte = $numeroCarte;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getTitulaire(): ?string
    {
        return $this->titulaire;
    }

    public function setTitulaire(string $titulaire): self
    {
        $this->titulaire = $titulaire;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getTypeMoyen(): ?string
    {
        return $this->typeMoyen;
    }

    public function setTypeMoyen(string $typeMoyen): self
    {
        $this->typeMoyen = $typeMoyen;

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
}
