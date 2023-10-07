<?php

namespace App\Entity;

use App\Repository\EducationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EducationRepository::class)
 */
class Education
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $annee;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialite;

/**
     * @ORM\OneToMany(targetEntity=Diplome::class, mappedBy="education")
     */
    private $diplome;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="education")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $institue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?float
    {
        return $this->annee;
    }

    public function setAnnee(float $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

     /**
     * @return Collection<int, diplome>
     */
    public function getDiplome(): Collection
    {
        return $this->diplome;
    }

    public function addDiplome(diplome $diplome): self
    {
        if (!$this->diplome->contains($diplome)) {
            $this->diplome[] = $diplome;
            $diplome->setEducation($this);
        }

        return $this;
    }

    public function removeDiplome(Diplome $diplome): self
    {
        if ($this->mission->removeElement($diplome)) {
            // set the owning side to null (unless already changed)
            if ($diplome->getEducation() === $this) {
                $diplome->setEducation(null);
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getInstitue(): ?string
    {
        return $this->institue;
    }

    public function setInstitue(string $institue): self
    {
        $this->institue = $institue;

        return $this;
    }
}
