<?php

namespace App\Entity;

use App\Repository\ModeleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ModeleRepository::class)
 */
class Modele
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le modèle est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le modèle doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le modèle ne peut pas dépasser {{ limit }} caractères"
     * )
     */
    private $nomModele;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="modeles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Marque;

    /**
     * @ORM\OneToMany(targetEntity=Voiture::class, mappedBy="Modele")
     */
    private $voitures;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="Modele")
     */
    private $images;

    public function __construct()
    {
        $this->voitures = new ArrayCollection();
        $this->images = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomModele(): ?string
    {
        return $this->nomModele;
    }

    public function setNomModele(string $nomModele): self
    {
        $this->nomModele = $nomModele;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->Marque;
    }

    public function setMarque(?Marque $Marque): self
    {
        $this->Marque = $Marque;

        return $this;
    }

    /**
     * @return Collection|Voiture[]
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }

    public function addVoiture(Voiture $voiture): self
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures[] = $voiture;
            $voiture->setModele($this);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): self
    {
        if ($this->voitures->removeElement($voiture)) {
            // set the owning side to null (unless already changed)
            if ($voiture->getModele() === $this) {
                $voiture->setModele(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setModele($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getModele() === $this) {
                $image->setModele(null);
            }
        }

        return $this;
    }

    public function __toString(){
        // to show the name of the Category in the select
        return $this->nomModele;
        // to show the id of the Category in the select
        // return $this->id;
    }
    
}
