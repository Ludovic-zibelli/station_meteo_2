<?php

namespace App\Entity;

use App\Repository\AlertMeteoFranceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlertMeteoFranceRepository::class)
 */
class AlertMeteoFrance
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
    private $couleurVigilance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $messageVigilance;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datedebut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datefin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCouleurVigilance(): ?string
    {
        return $this->couleurVigilance;
    }

    public function setCouleurVigilance(string $couleurVigilance): self
    {
        $this->couleurVigilance = $couleurVigilance;

        return $this;
    }

    public function getMessageVigilance(): ?string
    {
        return $this->messageVigilance;
    }

    public function setMessageVigilance(?string $messageVigilance): self
    {
        $this->messageVigilance = $messageVigilance;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(?\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }
}
