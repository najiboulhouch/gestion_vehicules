<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
class Option
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @Assert\Positive(message="Le prix doit être positif")
     * @Assert\NotBlank(message="Le prix est obligatoire")
     * 
     */
    private $prixOption;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'option est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "L'option doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "L'option ne peut pas dépasser {{ limit }} caractères"
     * )
     */
    private $nomPrix;

    /**
     * @ORM\ManyToOne(targetEntity=Voiture::class, inversedBy="options")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Voiture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixOption(): ?string
    {
        return $this->prixOption;
    }

    public function setPrixOption(string $prixOption): self
    {
        $this->prixOption = $prixOption;

        return $this;
    }

    public function getNomPrix(): ?string
    {
        return $this->nomPrix;
    }

    public function setNomPrix(string $nomPrix): self
    {
        $this->nomPrix = $nomPrix;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->Voiture;
    }

    public function setVoiture(?Voiture $Voiture): self
    {
        $this->Voiture = $Voiture;

        return $this;
    }
}
