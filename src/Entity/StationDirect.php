<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StationDirectRepository")
 * @ApiResource 
 */
class StationDirect
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
    private $dateheure;

    /**
     * @ORM\Column(type="float")
     */
    private $tempdh22;

    /**
     * @ORM\Column(type="float")
     */
    private $tempbmp280;

    /**
     * @ORM\Column(type="float")
     */
    private $humidite;

    /**
     * @ORM\Column(type="float")
     */
    private $pression;

    /**
     * @ORM\Column(type="float")
     */
    private $lumiere;

    /**
     * @ORM\Column(type="float")
     */
    private $anemometre;

    /**
     * @ORM\Column(type="integer")
     */
    private $girouette;

    /**
     * @ORM\Column(type="float")
     */
    private $pluviometre;

    /**
     * @ORM\Column(type="float")
     */
    private $point_rose;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateheure(): ?\DateTimeInterface
    {
        return $this->dateheure;
    }

    public function setDateheure(\DateTimeInterface $dateheure): self
    {
        $this->dateheure = $dateheure;

        return $this;
    }

    public function getTempdh22(): ?float
    {
        return $this->tempdh22;
    }

    public function setTempdh22(float $tempdh22): self
    {
        $this->tempdh22 = $tempdh22;

        return $this;
    }

    public function getTempbmp280(): ?float
    {
        return $this->tempbmp280;
    }

    public function setTempbmp280(float $tempbmp280): self
    {
        $this->tempbmp280 = $tempbmp280;

        return $this;
    }

    public function getHumidite(): ?float
    {
        return $this->humidite;
    }

    public function setHumidite(float $humidite): self
    {
        $this->humidite = $humidite;

        return $this;
    }

    public function getPression(): ?float
    {
        return $this->pression;
    }

    public function setPression(float $pression): self
    {
        $this->pression = $pression;

        return $this;
    }

    public function getLumiere(): ?float
    {
        return $this->lumiere;
    }

    public function setLumiere(float $lumiere): self
    {
        $this->lumiere = $lumiere;

        return $this;
    }

    public function getAnemometre(): ?float
    {
        return $this->anemometre;
    }

    public function setAnemometre(float $anemometre): self
    {
        $this->anemometre = $anemometre;

        return $this;
    }

    public function getGirouette(): ?int
    {
        return $this->girouette;
    }

    public function setGirouette(int $girouette): self
    {
        $this->girouette = $girouette;

        return $this;
    }

    public function getPluviometre(): ?float
    {
        return $this->pluviometre;
    }

    public function setPluviometre(float $pluviometre): self
    {
        $this->pluviometre = $pluviometre;

        return $this;
    }

    public function getPointRose(): ?float
    {
        return $this->point_rose;
    }

    public function setPointRose(float $point_rose): self
    {
        $this->point_rose = $point_rose;

        return $this;
    }
}
