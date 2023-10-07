<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string",nullable=true)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Projetspersonnel::class, mappedBy="user")
     */
    private $projetspersonnel; 

    /**
     * @ORM\OneToMany(targetEntity=Competences::class, mappedBy="user")
     */
    private $competences;

    /**
     * @ORM\OneToMany(targetEntity=Experience::class, mappedBy="user")
     */
    private $experience;

    /**
     * @ORM\oneToMany(targetEntity=Certificat::class, mappedBy="user")
     */
    private $certificat;

    /**
     * @ORM\OneToMany(targetEntity=Education::class, mappedBy="user")
     */
    private $education;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;
     /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $codePostal;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numtel;
/**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datedenaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addresse;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $domaine;
   /**
     * @ORM\oneToMany(targetEntity=Parametres::class, mappedBy="user")
     */
    private $parametres;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $anneeExperience;

    /**
     * @ORM\OneToMany(targetEntity=Poste::class, mappedBy="User")
     */
    private $postes;

    /**
     * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="sender", orphanRemoval=true)
     */
    private $sent;

    /**
     * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="recipient", orphanRemoval=true)
     */
    private $received;
    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="sender", orphanRemoval=true)
     */
    private $send;
     /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="recipient", orphanRemoval=true)
     */
    private $receive;
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datedecreation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombredesalaries;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomrh;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $domaineactivite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomsocitie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkPublic;

   

    public function __construct()
    {
        $this->projetspersonnel = new ArrayCollection(); 
        $this->competences = new ArrayCollection();
        $this->experience = new ArrayCollection();
        $this->certificat = new ArrayCollection();
        $this->parametres = new ArrayCollection();
        $this->education = new ArrayCollection();
        $this->postes = new ArrayCollection();
        $this->sent = new ArrayCollection();
        $this->received = new ArrayCollection();
        $this->send = new ArrayCollection();
        $this->receive = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getDatedenaissance(): ?\DateTimeInterface
    {
        return $this->datedenaissance;
    }

    public function setDatedenaissance(\DateTimeInterface $datedenaissance): self
    {
        $this->datedenaissance = $datedenaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    } 

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAnneeExperience()
    {
        return $this->anneeExperience;
    }
    
    public function setAnneeExperience($e)
    {
        $this->anneeExperience = $e;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
   
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Projetspersonnel>
     */
    public function getProjetspersonnel(): Collection
    {
        return $this->projetspersonnel;
    }

    public function addProjetspersonnel(Projetspersonnel $projetspersonnel): self
    {
        if (!$this->projetspersonnel->contains($projetspersonnel)) {
            $this->projetspersonnel[] = $projetspersonnel;
            $projetspersonnel->setUser($this);
        }

        return $this;
    }

    public function removeProjetspersonnel(Projetspersonnel $projetspersonnel): self
    {
        if ($this->projetspersonnel->removeElement($projetspersonnel)) {
            // set the owning side to null (unless already changed)
            if ($projetspersonnel->getUser() === $this) {
                $projetspersonnel->setUser(null);
            }
        }

        return $this;
    } 

    /**
     * @return Collection<int, Competences>
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competences $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->setUser($this);
        }

        return $this;
    }

    public function removeCompetence(Competences $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getUser() === $this) {
                $competence->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getExperience(): Collection
    {
        return $this->experience;
    }

    public function addExperience(Experience $experience): self
    {
        if (!$this->experience->contains($experience)) {
            $this->experience[] = $experience;
            $experience->setUser($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): self
    {
        if ($this->experience->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getUser() === $this) {
                $experience->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Certificat>
     */
    public function getCertificat(): Collection
    {
        return $this->certificat;
    }

    public function addCertificat(Certificat $certificat): self
    {
        if (!$this->certificat->contains($certificat)) {
            $this->certificat[] = $certificat;
        }

        return $this;
    }

    public function removeCertificat(Certificat $certificat): self
    {
        $this->certificat->removeElement($certificat);

        return $this;
    }

    /**
     * @return Collection<int, Education>
     */
    public function getEducation(): Collection
    {
        return $this->education;
    }

    public function addEducation(Education $education): self
    {
        if (!$this->education->contains($education)) {
            $this->education[] = $education;
            $education->setUser($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): self
    {
        if ($this->education->removeElement($education)) {
            // set the owning side to null (unless already changed)
            if ($education->getUser() === $this) {
                $education->setUser(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }
    public function getCodePostal(): ?float
    {
        return $this->codePostal;
    }

    public function setCodePostal(float $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
     * @return Collection<int, Parametres>
     */
    public function getParametres(): Collection
    {
        return $this->parametres;
    }

    public function addParametres(Parametres $parametres): self
    {
        if (!$this->parametres->contains($parametres)) {
            $this->parametres[] = $parametres;
        }

        return $this;
    }

    public function removeParametres(Parametres $parametres): self
    {
        $this->parametres->removeElement($parametres);

        return $this;
    }

    /**
     * @return Collection<int, Poste>
     */
    public function getPostes(): Collection
    {
        return $this->postes;
    }

    public function addPoste(Poste $poste): self
    {
        if (!$this->postes->contains($poste)) {
            $this->postes[] = $poste;
            $poste->setUser($this);
        }

        return $this;
    }

    public function removePoste(Poste $poste): self
    {
        if ($this->postes->removeElement($poste)) {
            // set the owning side to null (unless already changed)
            if ($poste->getUser() === $this) {
                $poste->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getSent(): Collection
    {
        return $this->sent;
    }

    public function addSent(Messages $sent): self
    {
        if (!$this->sent->contains($sent)) {
            $this->sent[] = $sent;
            $sent->setSender($this);
        }

        return $this;
    }

    public function removeSent(Messages $sent): self
    {
        if ($this->sent->removeElement($sent)) {
            // set the owning side to null (unless already changed)
            if ($sent->getSender() === $this) {
                $sent->setSender(null);
            }
        }

        return $this;
    }
    

    /**
     * @return Collection<int, Messages>
     */
    public function getReceived(): Collection
    {
        return $this->received;
    }

    public function addReceived(Messages $received): self
    {
        if (!$this->received->contains($received)) {
            $this->received[] = $received;
            $received->setRecipient($this);
        }

        return $this;
    }

    public function removeReceived(Messages $received): self
    {
        if ($this->received->removeElement($received)) {
            // set the owning side to null (unless already changed)
            if ($received->getRecipient() === $this) {
                $received->setRecipient(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->email;
    }
     /**
     * @return Collection<int, Contact>
     */
    public function getSend(): Collection
    {
        return $this->send;
    }

    public function addSend(Contact $send): self
    {
        if (!$this->send->contains($send)) {
            $this->send[] = $send;
            $send->setSender($this);
        }

        return $this;
    }

    public function removeSend(Contact $send): self
    {
        if ($this->sent->removeElement($send)) {
            // set the owning side to null (unless already changed)
            if ($send->getSender() === $this) {
                $send->setSender(null);
            }
        }

        return $this;
    }
       /**
     * @return Collection<int, Contact>
     */
    public function getReceive(): Collection
    {
        return $this->receive;
    }

    public function addReceive(Contact $receive): self
    {
        if (!$this->receive->contains($receive)) {
            $this->receive[] = $receive;
            $receive->setRecipient($this);
        }

        return $this;
    }

    public function removeReceive(Contact $receive): self
    {
        if ($this->receive->removeElement($receive)) {
            // set the owning side to null (unless already changed)
            if ($receive->getRecipient() === $this) {
                $receive->setRecipient(null);
            }
        }

        return $this;
    }

    public function getDatedecreation(): ?\DateTimeInterface
    {
        return $this->datedecreation;
    }

    public function setDatedecreation(?\DateTimeInterface $datedecreation): self
    {
        $this->datedecreation = $datedecreation;

        return $this;
    }

    public function getNombredesalaries(): ?int
    {
        return $this->nombredesalaries;
    }

    public function setNombredesalaries(?int $nombredesalaries): self
    {
        $this->nombredesalaries = $nombredesalaries;

        return $this;
    }

    public function getNomrh(): ?string
    {
        return $this->nomrh;
    }

    public function setNomrh(?string $nomrh): self
    {
        $this->nomrh = $nomrh;

        return $this;
    }

    public function getFax(): ?int
    {
        return $this->fax;
    }

    public function setFax(?int $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getDomaineactivite(): ?string
    {
        return $this->domaineactivite;
    }

    public function setDomaineactivite(?string $domaineactivite): self
    {
        $this->domaineactivite = $domaineactivite;

        return $this;
    }

    public function getNomsocitie(): ?string
    {
        return $this->nomsocitie;
    }

    public function setNomsocitie(?string $nomsocitie): self
    {
        $this->nomsocitie = $nomsocitie;

        return $this;
    }

    public function getLinkPublic(): ?string
    {
        return $this->linkPublic;
    }

    public function setLinkPublic(?string $linkPublic): self
    {
        $this->linkPublic = $linkPublic;

        return $this;
    }

    
}
