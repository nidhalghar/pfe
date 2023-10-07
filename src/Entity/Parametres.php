<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ParametresRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParametresRepository::class)
 */
class Parametres
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
    private $loisires;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $paragraphe;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $linkidin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $git;
   
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $linkPublic;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Parametres")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoCouv;

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Cv;
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoisires(): ?string
    {
        return $this->loisires;
    }

    public function setLoisires(string $loisires): self
    {
        $this->loisires = $loisires;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getParagraphe(): ?string
    {
        return $this->paragraphe;
    }

    public function setParagraphe(string $paragraphe): self
    {
        $this->paragraphe = $paragraphe;

        return $this;
    }

     

    public function getLinkidin(): ?string
    {
        return $this->linkidin;
    }

    public function setLinkidin(string $linkidin): self
    {
        $this->linkidin = $linkidin;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getGit(): ?string
    {
        return $this->git;
    }

    public function setGit(string $git): self
    {
        $this->git = $git;

        return $this;
    }


    public function getLinkPublic(): ?string
    {
        return $this->linkPublic;
    }

    public function setLinkPublic(string $linkPublic): self
    {
        $this->linkPublic = $linkPublic;

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
            $user->addParametres($this);
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
            $user->removeParametres($this);
        }

        return $this;
    }


    public function getPhotoCouv(): ?string
    {
        return $this->photoCouv;
    }

    public function setPhotoCouv(?string $photoCouv): self
    {
        $this->photoCouv = $photoCouv;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->Cv;
    }

    public function setCv(string $Cv): self
    {
        $this->Cv = $Cv;

        return $this;
    }
}
