<?php

namespace App\Entity;

use App\Repository\CertificatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CertificatRepository::class)
 */
class Certificat
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
    private $duree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domaine;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="certificat")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomCertificat;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?float
    {
        return $this->duree;
    }

    public function setDuree(float $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addCertificat($this);
        }

        return $this;
    }
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeCertificat($this);
        }

        return $this;
    }

    public function getNomCertificat(): ?string
    {
        return $this->NomCertificat;
    }

    public function setNomCertificat(string $NomCertificat): self
    {
        $this->NomCertificat = $NomCertificat;

        return $this;
    }
}
