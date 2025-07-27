<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StationDirectRepository")
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *             "method"="GET",
 *             "path"="/stationdirect"
 *         }
 *     },
 *     itemOperations={
 *         "get"={
 *             "method"="GET",
 *             "path"="/stationdirect/{id}"
 *         },
 *         "put"={
 *             "method"="PUT",
 *             "path"="/stationdirect/{id}"
 *         }
 *     }
 * )
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
     * 
     */
    private $dateheure;

    /**
     * @ORM\Column(type="float")
     * 
     */
    private $tempdh22;

    /**
     * @ORM\Column(type="float")
     */
    private $tempbmp280;

    /**
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="string")
     */
    private $point_rose;

    /**
     * @ORM\Column(type="integer")
     */
    private $Eclaire1km;

    /**
     * @ORM\Column(type="integer")
     */
    private $Eclaire10km;

    /**
     * @ORM\Column(type="integer")
     */
    private $Eclaire50km;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alertemeteofrance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couleurmeteofrance;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datedebutmeteofrance;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datefinmeteofrance;

    /**
     * @ORM\Column(type="bigint")
     */
    private $tpsvie;

    /**
     * @ORM\Column(type="integer")
     */
    private $ghost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * 
     */
    private ?int $station_id = null;

    /**
     * @ORM\OneToOne(targetEntity=StationMeteos::class, inversedBy="stationDirect", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="station_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * 
     */
    private ?StationMeteos $stationMeteos = null;
    

    public function __construct() {
        //$this->station = new ArrayCollection();
    }

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

    public function getHumidite(): ?int
    {
        return $this->humidite;
    }

    public function setHumidite(int $humidite): self
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

    public function getPointRose(): ?string
    {
        return $this->point_rose;
    }

    public function setPointRose(string $point_rose): self
    {
        $this->point_rose = $point_rose;

        return $this;
    }

    public function getEclaire1km(): ?int
    {
        return $this->Eclaire1km;
    }

    public function setEclaire1km(int $Eclaire1km): self
    {
        $this->Eclaire1km = $Eclaire1km;

        return $this;
    }

    public function getEclaire10km(): ?int
    {
        return $this->Eclaire10km;
    }

    public function setEclaire10km(int $Eclaire10km): self
    {
        $this->Eclaire10km = $Eclaire10km;

        return $this;
    }

    public function getEclaire50km(): ?int
    {
        return $this->Eclaire50km;
    }

    public function setEclaire50km(int $Eclaire50km): self
    {
        $this->Eclaire50km = $Eclaire50km;

        return $this;
    }

    public function getAlertemeteofrance(): ?string
    {
        return $this->alertemeteofrance;
    }

    public function setAlertemeteofrance(?string $alertemeteofrance): self
    {
        $this->alertemeteofrance = $alertemeteofrance;

        return $this;
    }

    public function getCouleurmeteofrance(): ?string
    {
        return $this->couleurmeteofrance;
    }

    public function setCouleurmeteofrance(string $couleurmeteofrance): self
    {
        $this->couleurmeteofrance = $couleurmeteofrance;

        return $this;
    }

    public function getDatedebutmeteofrance(): ?\DateTimeInterface
    {
        return $this->datedebutmeteofrance;
    }

    public function setDatedebutmeteofrance(?\DateTimeInterface $datedebutmeteofrance): self
    {
        $this->datedebutmeteofrance = $datedebutmeteofrance;

        return $this;
    }

    public function getDatefinmeteofrance(): ?\DateTimeInterface
    {
        return $this->datefinmeteofrance;
    }

    public function setDatefinmeteofrance(?\DateTimeInterface $datefinmeteofrance): self
    {
        $this->datefinmeteofrance = $datefinmeteofrance;

        return $this;
    }

    public function getTpsvie(): ?string
    {
        return $this->tpsvie;
    }

    public function setTpsvie(string $tpsvie): self
    {
        $this->tpsvie = $tpsvie;

        return $this;
    }

    public function getGhost(): ?int
    {
        return $this->ghost;
    }

    public function setGhost(int $ghost): self
    {
        $this->ghost = $ghost;

        return $this;
    }

    public function getStationId(): ?int
    {
        return $this->station_id;
    }

    public function setStationId(?int $station_id): self
    {
        $this->station_id = $station_id;

        return $this;
    }

    public function getStationMeteos(): ?StationMeteos
    {
        return $this->stationMeteos;
    }

    public function setStationMeteos(?StationMeteos $stationMeteos): self
    {
        $this->stationMeteos = $stationMeteos;

        // Assurez-vous que l'autre côté de la relation est correctement défini
        if ($stationMeteos !== null && $stationMeteos->getStationDirect() !== $this) {
            $stationMeteos->setStationDirect($this);
        }

        return $this;
    }
}
