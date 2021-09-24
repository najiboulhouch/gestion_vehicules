<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @Assert\NotBlank(message="Le prix est obligatoire")
     * @Assert\Positive(message="Le prix doit être positif")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Le kélométrage est obligatoire")
     * @Assert\PositiveOrZero(message="Le prix doit être positif")
     */
    private $km;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThanOrEqual("today", message="La date de construction doit être inférieure à la date d'aujourd'hui")
     */
    private $dateConstruction;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Choice({"Ocasion", "Neuve"} , message="{{ value  }} ne correspond pas avec les valeurs sauivantes :  {{ choices }}")
     */
    private $etat;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="dateConstruction", message="La date de mise en vente doit être supérieure à la date de construction")
     */
    private $dateMiseEnVente;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    private $disponibilite;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="La promotion est obligatoire")
     * @Assert\PositiveOrZero(message="La promotion doit être positive")
     * 
     */
    private $promotion;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="Voiure")
     */
    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity=Option::class, mappedBy="Voiture")
     */
    private $options;

    /**
     * @ORM\ManyToOne(targetEntity=Couleur::class, inversedBy="voitures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Couleur;

    /**
     * @ORM\ManyToOne(targetEntity=Carburant::class, inversedBy="voitures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Carburant;

    /**
     * @ORM\ManyToOne(targetEntity=Modele::class, inversedBy="voitures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Modele;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->options = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getDateConstruction(): ?\DateTimeInterface
    {
        return $this->dateConstruction;
    }

    public function setDateConstruction(\DateTimeInterface $dateConstruction): self
    {
        $this->dateConstruction = $dateConstruction;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDateMiseEnVente(): ?\DateTimeInterface
    {
        return $this->dateMiseEnVente;
    }

    public function setDateMiseEnVente(\DateTimeInterface $dateMiseEnVente): self
    {
        $this->dateMiseEnVente = $dateMiseEnVente;

        return $this;
    }

    public function getDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getPromotion(): ?int
    {
        return $this->promotion;
    }

    public function setPromotion(int $promotion): self
    {
        $this->promotion = $promotion;

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
            $commande->setVoiure($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getVoiure() === $this) {
                $commande->setVoiure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setVoiture($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getVoiture() === $this) {
                $option->setVoiture(null);
            }
        }

        return $this;
    }

    public function getCouleur(): ?Couleur
    {
        return $this->Couleur;
    }

    public function setCouleur(?Couleur $Couleur): self
    {
        $this->Couleur = $Couleur;

        return $this;
    }

    public function getCarburant(): ?Carburant
    {
        return $this->Carburant;
    }

    public function setCarburant(?Carburant $Carburant): self
    {
        $this->Carburant = $Carburant;

        return $this;
    }

    public function getModele(): ?Modele
    {
        return $this->Modele;
    }

    public function setModele(?Modele $Modele): self
    {
        $this->Modele = $Modele;

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

    public function __toString(){
        // to show the name of the Category in the select
        return $this->etat;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
