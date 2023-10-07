<?php

namespace App\Entity;

use App\Repository\DiplomeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiplomeRepository::class)
 */
class Diplome
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $montion;

    /**
     * @ORM\Column(type="float")
     */
    private $annee;

   /**
     * @ORM\ManyToOne(targetEntity=Education::class, inversedBy="diplome")
     */
    private $education;

    public function __construct()
    {
        $this->education = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontion(): ?string
    {
        return $this->montion;
    }

    public function setMontion(string $montion): self
    {
        $this->montion = $montion;

        return $this;
    }

    public function getAnnee(): ?float
    {
        return $this->annee;
    }

    public function setAnnee($annee)
    {
        if (is_string($annee)) {
            $annee = (float) $annee;
        }
        $this->annee = $annee;
    }

    /**
     * @return Collection<int, Education>
     */
    public function getEducation(): ?Education
    {
        return $this->education;
    }

    public function setEducation(?Education $education): self
    {
        $this->education = $education;

        return $this;
    }
}