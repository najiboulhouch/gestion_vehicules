<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Le nom du client est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom du client doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du client ne peut pas dépasser {{ limit }} caractères"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $nomClient;

    /**
     * @Assert\NotBlank(message="L'adresse du client est obligatoire")
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "L'adreesse du client doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "L'adreesse du client ne peut pas dépasser {{ limit }} caractères"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @Assert\NotBlank(message="Le téléphone du client est obligatoire")
     * @Assert\Length(
     *      min = 8,
     *      max = 12,
     *      minMessage = "Le téléphone du client doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "L'téléphone du client ne peut pas dépasser {{ limit }} caractères"
     * )
     * @ORM\Column(type="string", length=20)
     */
    private $tel;

    /**
     * @Assert\NotBlank(message="L'email du client est obligatoire")
     *  @Assert\Email(
     *     message = "L'email du client'{{ value }}' est non valide")
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="Client")
     */
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    public function __toString(){
        // to show the name of the Category in the select
        return $this->nomClient;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
