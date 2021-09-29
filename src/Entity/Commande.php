<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Date de commande est obligatoire")
     */
    private $dateRdv;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le commentaire est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le commentaire doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le commentaire ne peut pas dépasser {{ limit }} caractères"
     * )
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commandes" , 
     * cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Client;

    /**
     * @ORM\ManyToOne(targetEntity=Voiture::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Voiure;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRdv(): ?\DateTimeInterface
    {
        return $this->dateRdv;
    }

    public function setDateRdv(\DateTimeInterface $dateRdv): self
    {
        $this->dateRdv = $dateRdv;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public function getVoiure(): ?Voiture
    {
        return $this->Voiure;
    }

    public function setVoiure(?Voiture $Voiure): self
    {
        $this->Voiure = $Voiure;

        return $this;
    }
}
