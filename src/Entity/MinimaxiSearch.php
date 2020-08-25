<?php

namespace App\Entity;

class MinimaxiSearch
{
    /**
     * @var \DateTime|null
     */
    private $date;


    /**
     * @var \DateTime|null
     */
    private $date_interval;

    /**
     * @return \DateTime|null
     */
    public function getDateInterval(): ?\DateTime
    {
        return $this->date_interval;
    }

    /**
     * @param \DateTime|null $date_interval
     * @return MinimaxiSearch
     */
    public function setDateInterval(?\DateTime $date_interval): MinimaxiSearch
    {
        $this->date_interval = $date_interval;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     * @return MinimaxiSearch
     */
    public function setDate(?\DateTime $date): MinimaxiSearch
    {
        $this->date = $date;
        //$this->date_interval = $date->add(new \DateInterval('P1D'));
        //$date->modify("+1 day");
        return $this;
    }

}