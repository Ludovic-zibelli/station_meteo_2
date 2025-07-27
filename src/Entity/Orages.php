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
     * Rayon de recherche (1, 10 ou 50 km)
     * @ORM\Column(type="integer")
     */
    private $radius;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $start_time;

    /**
     * @ORM\Column(type="integer")
     */
    private $end_time;

    /**
     * @ORM\Column(type="float")
     */
    private $lat;

    /**
     * @ORM\Column(type="float")
     */
    private $lon;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="json")
     */
    private $intervals = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $total_strikes;

    /**
     * @ORM\Column(type="json")
     */
    private $bearings = [];

    /**
     * @ORM\Column(type="json")
     */
    private $closests = [];

    /**
     * @ORM\Column(type="json")
     */
    private $by_intervals = [];

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datetime;

    public function __construct()
    {
        $this->datetime = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRadius(): ?int
    {
        return $this->radius;
    }

    public function setRadius(int $radius): self
    {
        $this->radius = $radius;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getStartTime(): ?int
    {
        return $this->start_time;
    }

    public function setStartTime(int $start_time): self
    {
        $this->start_time = $start_time;
        return $this;
    }

    public function getEndTime(): ?int
    {
        return $this->end_time;
    }

    public function setEndTime(int $end_time): self
    {
        $this->end_time = $end_time;
        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;
        return $this;
    }

    public function getLon(): ?float
    {
        return $this->lon;
    }

    public function setLon(float $lon): self
    {
        $this->lon = $lon;
        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getIntervals(): array
    {
        return $this->intervals;
    }

    public function setIntervals(array $intervals): self
    {
        $this->intervals = $intervals;
        return $this;
    }

    public function getTotalStrikes(): ?int
    {
        return $this->total_strikes;
    }

    public function setTotalStrikes(int $total_strikes): self
    {
        $this->total_strikes = $total_strikes;
        return $this;
    }

    public function getBearings(): array
    {
        return $this->bearings;
    }

    public function setBearings(array $bearings): self
    {
        $this->bearings = $bearings;
        return $this;
    }

    public function getClosests(): array
    {
        return $this->closests;
    }

    public function setClosests(array $closests): self
    {
        $this->closests = $closests;
        return $this;
    }

    public function getByIntervals(): array
    {
        return $this->by_intervals;
    }

    public function setByIntervals(array $by_intervals): self
    {
        $this->by_intervals = $by_intervals;
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
