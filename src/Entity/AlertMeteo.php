<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlertMeteoRepository")
 */
class AlertMeteo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatd_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $online;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictogramme;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $code_phenomene;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $origine;

    public function __construct()
    {
        $this->creatd_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatdAt(): ?\DateTimeInterface
    {
        return $this->creatd_at;
    }

    public function setCreatdAt(\DateTimeInterface $creatd_at): self
    {
        $this->creatd_at = $creatd_at;

        return $this;
    }

    public function getType(): ?bool
    {
        return $this->type;
    }

    public function setType(bool $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPictogramme(): ?string
    {
        return $this->pictogramme;
    }

    public function setPictogramme(?string $pictogramme): self
    {
        $this->pictogramme = $pictogramme;

        return $this;
    }

    public function getCodePhenomene(): ?int
    {
        return $this->code_phenomene;
    }

    public function setCodePhenomene(?int $code_phenomene): self
    {
        $this->code_phenomene = $code_phenomene;

        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(?string $origine): self
    {
        $this->origine = $origine;

        return $this;
    }
}
