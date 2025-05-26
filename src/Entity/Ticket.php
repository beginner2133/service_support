<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Statut;       
use App\Entity\Utilisateur;  

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $auteurEmail = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTime $dateOuverture = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateCloture = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')] 
    #[ORM\JoinColumn(nullable: false)]
    private ?Statut $statut = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')] 
    #[ORM\JoinColumn(nullable: true)]
    private ?Utilisateur $responsable = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteurEmail(): ?string
    {
        return $this->auteurEmail;
    }

    public function setAuteurEmail(string $auteurEmail): static
    {
        $this->auteurEmail = $auteurEmail;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateOuverture(): ?\DateTime
    {
        return $this->dateOuverture;
    }

    public function setDateOuverture(\DateTime $dateOuverture): static
    {
        $this->dateOuverture = $dateOuverture;

        return $this;
    }

    public function getDateCloture(): ?\DateTime
    {
        return $this->dateCloture;
    }

    public function setDateCloture(?\DateTime $dateCloture): static
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    // Getters et Setters pour statut & responsable
    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getResponsable(): ?Utilisateur
    {
        return $this->responsable;
    }

    public function setResponsable(?Utilisateur $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }
}
