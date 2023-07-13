<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $naissance = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $rue_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $cp_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $ville_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $pays_adresse = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commentaire::class)]
    private Collection $relation;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Panier $panier = null;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getNaissance(): ?\DateTimeInterface
    {
        return $this->naissance;
    }

    public function setNaissance(\DateTimeInterface $naissance): static
    {
        $this->naissance = $naissance;

        return $this;
    }

    public function getNumeroAdresse(): ?string
    {
        return $this->numero_adresse;
    }

    public function setNumeroAdresse(string $numero_adresse): static
    {
        $this->numero_adresse = $numero_adresse;

        return $this;
    }

    public function getRueAdresse(): ?string
    {
        return $this->rue_adresse;
    }

    public function setRueAdresse(string $rue_adresse): static
    {
        $this->rue_adresse = $rue_adresse;

        return $this;
    }

    public function getCpAdresse(): ?string
    {
        return $this->cp_adresse;
    }

    public function setCpAdresse(string $cp_adresse): static
    {
        $this->cp_adresse = $cp_adresse;

        return $this;
    }

    public function getVilleAdresse(): ?string
    {
        return $this->ville_adresse;
    }

    public function setVilleAdresse(string $ville_adresse): static
    {
        $this->ville_adresse = $ville_adresse;

        return $this;
    }

    public function getPaysAdresse(): ?string
    {
        return $this->pays_adresse;
    }

    public function setPaysAdresse(string $pays_adresse): static
    {
        $this->pays_adresse = $pays_adresse;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Commentaire $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setUser($this);
        }

        return $this;
    }

    public function removeRelation(Commentaire $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getUser() === $this) {
                $relation->setUser(null);
            }
        }

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): static
    {
        $this->panier = $panier;

        return $this;
    }



}
