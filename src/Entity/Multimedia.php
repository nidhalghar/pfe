<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\MultimediaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MultimediaRepository::class)
 */
class Multimedia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $lien;

    /**
     * @ORM\ManyToOne(targetEntity=Projetspersonnel::class, inversedBy="multimedia")
     */
    private $projetspersonnel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\NotBlank(message="please Upload image")
     * @Assert\File(mimeTypes={"image/jpeg"})
     */
    private $image;
    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getProjetspersonnel(): ?Projetspersonnel
    {
        return $this->projetspersonnel;
    }

    public function setProjetspersonnel(?Projetspersonnel $projetspersonnel): self
    {
        $this->projetspersonnel = $projetspersonnel;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage( $image)
    {
        $this->image = $image;

        return $this;
    }

  
}
