<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EtatStationMeteoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatStationMeteoRepository::class)
 * @ApiResource(
 * 
 *     collectionOperations={
 *         "get"={
 *             "method"="GET",
 *             "path"="/etatstationmeteo"
 *         }
 *     },
 *     itemOperations={
 *         "get"={
 *             "method"="GET",
 *             "path"="/etatstationmeteo/{id}"
 *         },
 *         "put"={
 *             "method"="PUT",
 *             "path"="/etatstationmeteo/{id}"
 *         },
 *        "patch"={"method"="PATCH","path"="/etatstationmeteo/{id}"} 
 *     }
 * )
 */

class EtatStationMeteo
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
    private $module_bmp280;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $module_dht22;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $module_anemo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $module_girou;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $module_pluvio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $module_tension;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $module_bitvie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capteur_dht22;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capteur_bmp280;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capteur_pluvio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capteur_girou;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capteur_anemo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ghost;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $log_date_bmp280;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $log_bmp280;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $log_date_dht22;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $log_dht22;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $log_date_girou;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $log_girou;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $log_date_tension;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $log_tension;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $log_date_anemo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $log_anemo;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $log_date_pluvio;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $log_pluvio;

    /**
     * @ORM\OneToOne(targetEntity=StationMeteos::class, inversedBy="etatStationMeteo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="station_meteo_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $stationMeteo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModuleBmp280(): ?int
    {
        return $this->module_bmp280;
    }

    public function setModuleBmp280(?int $module_bmp280): self
    {
        $this->module_bmp280 = $module_bmp280;

        return $this;
    }

    public function getModuleDht22(): ?int
    {
        return $this->module_dht22;
    }

    public function setModuleDht22(?int $module_dht22): self
    {
        $this->module_dht22 = $module_dht22;

        return $this;
    }

    public function getModuleAnemo(): ?int
    {
        return $this->module_anemo;
    }

    public function setModuleAnemo(?int $module_anemo): self
    {
        $this->module_anemo = $module_anemo;

        return $this;
    }

    public function getModuleGirou(): ?int
    {
        return $this->module_girou;
    }

    public function setModuleGirou(?int $module_girou): self
    {
        $this->module_girou = $module_girou;

        return $this;
    }

    public function getModulePluvio(): ?int
    {
        return $this->module_pluvio;
    }

    public function setModulePluvio(?int $module_pluvio): self
    {
        $this->module_pluvio = $module_pluvio;

        return $this;
    }

    public function getModuleTension(): ?int
    {
        return $this->module_tension;
    }

    public function setModuleTension(?int $module_tension): self
    {
        $this->module_tension = $module_tension;

        return $this;
    }

    public function getModuleBitvie(): ?int
    {
        return $this->module_bitvie;
    }

    public function setModuleBitvie(?int $module_bitvie): self
    {
        $this->module_bitvie = $module_bitvie;

        return $this;
    }

    public function getCapteurDht22(): ?int
    {
        return $this->capteur_dht22;
    }

    public function setCapteurDht22(?int $capteur_dht22): self
    {
        $this->capteur_dht22 = $capteur_dht22;

        return $this;
    }

    public function getCapteurBmp280(): ?int
    {
        return $this->capteur_bmp280;
    }

    public function setCapteurBmp280(?int $capteur_bmp280): self
    {
        $this->capteur_bmp280 = $capteur_bmp280;

        return $this;
    }

    public function getCapteurPluvio(): ?int
    {
        return $this->capteur_pluvio;
    }

    public function setCapteurPluvio(?int $capteur_pluvio): self
    {
        $this->capteur_pluvio = $capteur_pluvio;

        return $this;
    }

    public function getCapteurGirou(): ?int
    {
        return $this->capteur_girou;
    }

    public function setCapteurGirou(?int $capteur_girou): self
    {
        $this->capteur_girou = $capteur_girou;

        return $this;
    }

    public function getCapteurAnemo(): ?int
    {
        return $this->capteur_anemo;
    }

    public function setCapteurAnemo(?int $capteur_anemo): self
    {
        $this->capteur_anemo = $capteur_anemo;

        return $this;
    }

    public function getGhost(): ?int
    {
        return $this->ghost;
    }

    public function setGhost(?int $ghost): self
    {
        $this->ghost = $ghost;

        return $this;
    }

    public function getLogDateBmp280(): ?\DateTimeInterface
    {
        return $this->log_date_bmp280;
    }

    public function setLogDateBmp280(?\DateTimeInterface $log_date_bmp280): self
    {
        $this->log_date_bmp280 = $log_date_bmp280;

        return $this;
    }

    public function getLogBmp280(): ?string
    {
        return $this->log_bmp280;
    }

    public function setLogBmp280(?string $log_bmp280): self
    {
        $this->log_bmp280 = $log_bmp280;

        return $this;
    }

    public function getLogDateDht22(): ?\DateTimeInterface
    {
        return $this->log_date_dht22;
    }

    public function setLogDateDht22(?\DateTimeInterface $log_date_dht22): self
    {
        $this->log_date_dht22 = $log_date_dht22;

        return $this;
    }

    public function getLogDht22(): ?string
    {
        return $this->log_dht22;
    }

    public function setLogDht22(?string $log_dht22): self
    {
        $this->log_dht22 = $log_dht22;

        return $this;
    }

    public function getLogDateGirou(): ?\DateTimeInterface
    {
        return $this->log_date_girou;
    }

    public function setLogDateGirou(?\DateTimeInterface $log_date_girou): self
    {
        $this->log_date_girou = $log_date_girou;

        return $this;
    }

    public function getLogGirou(): ?string
    {
        return $this->log_girou;
    }

    public function setLogGirou(?string $log_girou): self
    {
        $this->log_girou = $log_girou;

        return $this;
    }

    public function getLogDateTension(): ?\DateTimeInterface
    {
        return $this->log_date_tension;
    }

    public function setLogDateTension(?\DateTimeInterface $log_date_tension): self
    {
        $this->log_date_tension = $log_date_tension;

        return $this;
    }

    public function getLogTension(): ?string
    {
        return $this->log_tension;
    }

    public function setLogTension(?string $log_tension): self
    {
        $this->log_tension = $log_tension;

        return $this;
    }

    public function getLogDateAnemo(): ?\DateTimeInterface
    {
        return $this->log_date_anemo;
    }

    public function setLogDateAnemo(?\DateTimeInterface $log_date_anemo): self
    {
        $this->log_date_anemo = $log_date_anemo;

        return $this;
    }

    public function getLogAnemo(): ?string
    {
        return $this->log_anemo;
    }

    public function setLogAnemo(?string $log_anemo): self
    {
        $this->log_anemo = $log_anemo;

        return $this;
    }

    public function getLogDatePluvio(): ?\DateTimeInterface
    {
        return $this->log_date_pluvio;
    }

    public function setLogDatePluvio(?\DateTimeInterface $log_date_pluvio): self
    {
        $this->log_date_pluvio = $log_date_pluvio;

        return $this;
    }

    public function getLogPluvio(): ?string
    {
        return $this->log_pluvio;
    }

    public function setLogPluvio(?string $log_pluvio): self
    {
        $this->log_pluvio = $log_pluvio;

        return $this;
    }

    public function getStationMeteo(): ?StationMeteos
    {
        return $this->stationMeteo;
    }

    public function setStationMeteo(?StationMeteos $stationMeteo): self
    {
        $this->stationMeteo = $stationMeteo;

        return $this;
    }
}
