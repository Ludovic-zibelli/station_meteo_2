<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Arcticles", mappedBy="category")
     */
    private $arcticles;

    public function __construct()
    {
        $this->arcticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Arcticles[]
     */
    public function getArcticles(): Collection
    {
        return $this->arcticles;
    }

    public function addArcticle(Arcticles $arcticle): self
    {
        if (!$this->arcticles->contains($arcticle)) {
            $this->arcticles[] = $arcticle;
            $arcticle->setCategory($this);
        }

        return $this;
    }

    public function removeArcticle(Arcticles $arcticle): self
    {
        if ($this->arcticles->contains($arcticle)) {
            $this->arcticles->removeElement($arcticle);
            // set the owning side to null (unless already changed)
            if ($arcticle->getCategory() === $this) {
                $arcticle->setCategory(null);
            }
        }

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString()
    {
           return $this->getCategory();
    }
}
