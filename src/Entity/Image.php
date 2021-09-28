<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="L'image est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "L'image doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "L'image ne peut pas dépasser {{ limit }} caractères"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $nomImage;

    /**
     * @ORM\ManyToOne(targetEntity=Modele::class, inversedBy="images" , 
     * cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Modele;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomImage(): ?string
    {
        return $this->nomImage;
    }

    public function setNomImage(string $nomImage): self
    {
        $this->nomImage = $nomImage;

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

    public function __toString(){
        return $this->nomImage;
    }
}
