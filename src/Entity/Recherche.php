<?php

namespace App\Entity;

class Recherche
{
    /**
     * @var \DateTime|null
     */
    private $date_debut;

    /**
     * @var \DateTime|null
     */
    private $date_fin;
    /**
     * @var int|null
     */
    private $filtre;

    /**
     * @return \DateTime|null
     */
    public function getDateDebut(): ?\DateTime
    {
        return $this->date_debut;
    }

    /**
     * @param \DateTime|null $date_debut
     * @return Recherche
     */
    public function setDateDebut(?\DateTime $date_debut): Recherche
    {
        $this->date_debut = $date_debut;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateFin(): ?\DateTime
    {
        return $this->date_fin;
    }

    /**
     * @param \DateTime|null $date_fin
     * @return Recherche
     */
    public function setDateFin(?\DateTime $date_fin): Recherche
    {
        $this->date_fin = $date_fin;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFiltre(): ?int
    {
        return $this->filtre;
    }

    /**
     * @param int|null $filtre
     * @return Recherche
     */
    public function setFiltre(?int $filtre): Recherche
    {
        $this->filtre = $filtre;
        return $this;
    }










}