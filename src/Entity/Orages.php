<?php

namespace App\Entity;

use App\Repository\OragesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OragesRepository::class)
 */
class Orages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $eclaires_1_km;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $eclaire_10_km;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $eclaires_50_km;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datetime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEclaires1Km(): ?int
    {
        return $this->eclaires_1_km;
    }

    public function setEclaires1Km(?int $eclaires_1_km): self
    {
        $this->eclaires_1_km = $eclaires_1_km;

        return $this;
    }

    public function getEclaire10Km(): ?int
    {
        return $this->eclaire_10_km;
    }

    public function setEclaire10Km(?int $eclaire_10_km): self
    {
        $this->eclaire_10_km = $eclaire_10_km;

        return $this;
    }

    public function getEclaires50Km(): ?int
    {
        return $this->eclaires_50_km;
    }

    public function setEclaires50Km(?int $eclaires_50_km): self
    {
        $this->eclaires_50_km = $eclaires_50_km;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(?\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }
}
