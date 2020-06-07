<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MiniMaxiHRepository")
 */
class MiniMaxiH
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mini_temp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $maxi_temp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mini_humi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $maxi_humi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mini_pres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $maxi_pres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mini_lumi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mini_ptro;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $maxi_ptro;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mini_anemo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $maxi_anemo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mini_girou;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $maxi_girou;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mini_pluvio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $maxi_pluvio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $maxi_lumi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMiniTemp(): ?string
    {
        return $this->mini_temp;
    }

    public function setMiniTemp(string $mini_temp): self
    {
        $this->mini_temp = $mini_temp;

        return $this;
    }

    public function getMaxiTemp(): ?string
    {
        return $this->maxi_temp;
    }

    public function setMaxiTemp(string $maxi_temp): self
    {
        $this->maxi_temp = $maxi_temp;

        return $this;
    }

    public function getMiniHumi(): ?string
    {
        return $this->mini_humi;
    }

    public function setMiniHumi(string $mini_humi): self
    {
        $this->mini_humi = $mini_humi;

        return $this;
    }

    public function getMaxiHumi(): ?string
    {
        return $this->maxi_humi;
    }

    public function setMaxiHumi(string $maxi_humi): self
    {
        $this->maxi_humi = $maxi_humi;

        return $this;
    }

    public function getMiniPres(): ?string
    {
        return $this->mini_pres;
    }

    public function setMiniPres(string $mini_pres): self
    {
        $this->mini_pres = $mini_pres;

        return $this;
    }

    public function getMaxiPres(): ?string
    {
        return $this->maxi_pres;
    }

    public function setMaxiPres(string $maxi_pres): self
    {
        $this->maxi_pres = $maxi_pres;

        return $this;
    }

    public function getMiniLumi(): ?string
    {
        return $this->mini_lumi;
    }

    public function setMiniLumi(string $mini_lumi): self
    {
        $this->mini_lumi = $mini_lumi;

        return $this;
    }

    public function getMiniPtro(): ?string
    {
        return $this->mini_ptro;
    }

    public function setMiniPtro(string $mini_ptro): self
    {
        $this->mini_ptro = $mini_ptro;

        return $this;
    }

    public function getMaxiPtro(): ?string
    {
        return $this->maxi_ptro;
    }

    public function setMaxiPtro(string $maxi_ptro): self
    {
        $this->maxi_ptro = $maxi_ptro;

        return $this;
    }

    public function getMiniAnemo(): ?string
    {
        return $this->mini_anemo;
    }

    public function setMiniAnemo(string $mini_anemo): self
    {
        $this->mini_anemo = $mini_anemo;

        return $this;
    }

    public function getMaxiAnemo(): ?string
    {
        return $this->maxi_anemo;
    }

    public function setMaxiAnemo(string $maxi_anemo): self
    {
        $this->maxi_anemo = $maxi_anemo;

        return $this;
    }

    public function getMiniGirou(): ?string
    {
        return $this->mini_girou;
    }

    public function setMiniGirou(string $mini_girou): self
    {
        $this->mini_girou = $mini_girou;

        return $this;
    }

    public function getMaxiGirou(): ?string
    {
        return $this->maxi_girou;
    }

    public function setMaxiGirou(string $maxi_girou): self
    {
        $this->maxi_girou = $maxi_girou;

        return $this;
    }

    public function getMiniPluvio(): ?string
    {
        return $this->mini_pluvio;
    }

    public function setMiniPluvio(string $mini_pluvio): self
    {
        $this->mini_pluvio = $mini_pluvio;

        return $this;
    }

    public function getMaxiPluvio(): ?string
    {
        return $this->maxi_pluvio;
    }

    public function setMaxiPluvio(string $maxi_pluvio): self
    {
        $this->maxi_pluvio = $maxi_pluvio;

        return $this;
    }

    public function getMaxiLumi(): ?string
    {
        return $this->maxi_lumi;
    }

    public function setMaxiLumi(string $maxi_lumi): self
    {
        $this->maxi_lumi = $maxi_lumi;

        return $this;
    }
}
