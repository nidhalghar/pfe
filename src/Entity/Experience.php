<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExperienceRepository::class)
 */
class Experience
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Mission::class, mappedBy="experience")
     */
    private $mission;

   /**
     * @ORM\OneToMany(targetEntity=Projet::class, mappedBy="experience")
     */
    private $projet;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="experience")
     */
    private $user;

    /**
     * @ORM\Column(type="date")
     */
    private $datededebut;

    /**
     * @ORM\Column(type="date")
     */
    private $datedefin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomexperience;

    public function __construct()
    {
        $this->mission = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, mission>
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }

    public function addMission(mission $mission): self
    {
        if (!$this->mission->contains($mission)) {
            $this->mission[] = $mission;
            $mission->setExperience($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->mission->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getExperience() === $this) {
                $mission->setExperience(null);
            }
        }

        return $this;
    }

      /**
     * @return Collection<int, projet>
     */
    public function getProjet(): Collection
    {
        return $this->projet;
    }

    public function addProjet(mission $projet): self
    {
        if (!$this->projet->contains($projet)) {
            $this->projet[] = $projet;
            $projet->setExperience($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): self
    {
        if ($this->mission->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getExperience() === $this) {
                $projet->setExperience(null);
            }
        }

        return $this;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDatededebut(): ?\DateTimeInterface
    {
        return $this->datededebut;
    }

    public function setDatededebut(\DateTimeInterface $datededebut): self
    {
        $this->datededebut = $datededebut;

        return $this;
    }

    public function getDatedefin(): ?\DateTimeInterface
    {
        return $this->datedefin;
    }

    public function setDatedefin(\DateTimeInterface $datedefin): self
    {
        $this->datedefin = $datedefin;

        return $this;
    }

    public function getNomExperience(): ?string
    {
        return $this->nomexperience;
    }

    public function setNomexperience(string $nomexperience): self
    {
        $this->nomexperience = $nomexperience;

        return $this;
    }
 
}
