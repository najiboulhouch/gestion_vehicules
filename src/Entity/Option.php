<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $prixOption;

    /**
     * @ORM\Column(type="string", length=255)
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
