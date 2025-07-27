<?php

namespace App\Entity;

use App\Repository\SiteConfigRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SiteConfigRepository::class)
 */
class SiteConfig
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $maintenance;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_time_main;

    /**
     * @ORM\Column(type="boolean")
     */
    private $view_station;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_time_view;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaintenance(): ?bool
    {
        return $this->maintenance;
    }

    public function setMaintenance(bool $maintenance): self
    {
        $this->maintenance = $maintenance;

        return $this;
    }

    public function getDateTimeMain(): ?\DateTimeInterface
    {
        return $this->date_time_main;
    }

    public function setDateTimeMain(\DateTimeInterface $date_time_main): self
    {
        $this->date_time_main = $date_time_main;

        return $this;
    }

    public function getViewStation(): ?bool
    {
        return $this->view_station;
    }

    public function setViewStation(bool $view_station): self
    {
        $this->view_station = $view_station;

        return $this;
    }

    public function getDateTimeView(): ?\DateTimeInterface
    {
        return $this->date_time_view;
    }

    public function setDateTimeView(\DateTimeInterface $date_time_view): self
    {
        $this->date_time_view = $date_time_view;

        return $this;
    }
}
