<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * 
 * @ApiResource(
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"station:read", "user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"station:read", "user:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"station:read", "user:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"station:read", "user:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=StationMeteos::class, mappedBy="user")
     */
    private $stationMeteos;



    public function __construct()
    {

        $this->created_at = new \DateTime();
        $this->stationMeteos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

        /**
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

    /**
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }
 
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * @return Collection<int, StationMeteos>
     */
    public function getStationMeteos(): Collection
    {
        return $this->stationMeteos;
    }

    public function addStationMeteo(StationMeteos $stationMeteo): self
    {
        if (!$this->stationMeteos->contains($stationMeteo)) {
            $this->stationMeteos[] = $stationMeteo;
            $stationMeteo->setUser($this);
        }

        return $this;
    }

    public function removeStationMeteo(StationMeteos $stationMeteo): self
    {
        if ($this->stationMeteos->removeElement($stationMeteo)) {
            // set the owning side to null (unless already changed)
            if ($stationMeteo->getUser() === $this) {
                $stationMeteo->setUser(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->getEmail(); // Remplacer champ par une propriété "string" de l'entité
    }
    
}
