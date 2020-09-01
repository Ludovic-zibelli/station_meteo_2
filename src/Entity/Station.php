<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StationRepository")
 */
class Station
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
    private $date_heure;

    /**
     * @ORM\Column(type="integer")
     */
    private $temperature;

    /**
     * @ORM\Column(type="integer")
     */
    private $humiditer;

    /**
     * @ORM\Column(type="integer")
     */
    private $pression;

    /**
     * @ORM\Column(type="integer")
     */
    private $lumiere;

    /**
     * @ORM\Column(type="integer")
     */
    private $anemometre;

    /**
     * @ORM\Column(type="integer")
     */
    private $girouette;

    /**
     * @ORM\Column(type="integer")
     */
    private $pluviometre;

    /**
     * @ORM\Column(type="string")
     */
    private $point_rosee;


    public function __construct()
    {
        $this->date_heure = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->date_heure;
    }

    public function setDateHeure(\DateTimeInterface $date_heure): self
    {
        $this->date_heure = $date_heure;

        return $this;
    }

    public function getTemperature(): ?int
    {
        return $this->temperature;
    }

    public function setTemperature(int $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getHumiditer(): ?int
    {
        return $this->humiditer;
    }

    public function setHumiditer(int $humiditer): self
    {
        $this->humiditer = $humiditer;

        return $this;
    }

    public function getPression(): ?int
    {
        return $this->pression;
    }

    public function setPression(int $pression): self
    {
        $this->pression = $pression;

        return $this;
    }

    public function getLumiere(): ?int
    {
        return $this->lumiere;
    }

    public function setLumiere(int $lumiere): self
    {
        $this->lumiere = $lumiere;

        return $this;
    }

    public function getAnemometre(): ?int
    {
        return $this->anemometre;
    }

    public function setAnemometre(int $anemometre): self
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

    public function getPluviometre(): ?int
    {
        return $this->pluviometre;
    }

    public function setPluviometre(int $pluviometre): self
    {
        $this->pluviometre = $pluviometre;

        return $this;
    }

    public function getPointRosee(): ?string
    {
        return $this->point_rosee;
    }

    public function setPointRosee(string $point_rosee): self
    {
        $this->point_rosee = $point_rosee;

        return $this;
    }


}
