<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VigilanceMeteofranceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VigilanceMeteofranceRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *             "method"="GET",
 *             "path"="/vigilancemeteofrance"
 *         }
 *     },
 *     itemOperations={
 *         "get"={
 *             "method"="GET",
 *             "path"="/vigilancemeteofrance/{id}"
 *         }
 *     }
 * )
 */

class VigilanceMeteofrance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $domaine_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domaine_name;

    /**
     * @ORM\Column(type="text")
     */
    private $bloc_title;

    /**
     * @ORM\Column(type="text")
     */
    private $bloc_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $term_names;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start_time;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end_time;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $risk_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $risk_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $risk_color;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $risk_level;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text_1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bold_text_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bold_text_2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text_3;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text_4;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text_5;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text_6;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hazard_code;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text21;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text22;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text23;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text24;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text25;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text26;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomaineId(): ?int
    {
        return $this->domaine_id;
    }

    public function setDomaineId(int $domaine_id): self
    {
        $this->domaine_id = $domaine_id;

        return $this;
    }

    public function getDomaineName(): ?string
    {
        return $this->domaine_name;
    }

    public function setDomaineName(string $domaine_name): self
    {
        $this->domaine_name = $domaine_name;

        return $this;
    }

    public function getBlocTitle(): ?string
    {
        return $this->bloc_title;
    }

    public function setBlocTitle(string $bloc_title): self
    {
        $this->bloc_title = $bloc_title;

        return $this;
    }

    public function getBlocId(): ?string
    {
        return $this->bloc_id;
    }

    public function setBlocId(string $bloc_id): self
    {
        $this->bloc_id = $bloc_id;

        return $this;
    }

    public function getTermNames(): ?string
    {
        return $this->term_names;
    }

    public function setTermNames(?string $term_names): self
    {
        $this->term_names = $term_names;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(?\DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(?\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getRiskName(): ?string
    {
        return $this->risk_name;
    }

    public function setRiskName(?string $risk_name): self
    {
        $this->risk_name = $risk_name;

        return $this;
    }

    public function getRiskCode(): ?int
    {
        return $this->risk_code;
    }

    public function setRiskCode(?int $risk_code): self
    {
        $this->risk_code = $risk_code;

        return $this;
    }

    public function getRiskColor(): ?string
    {
        return $this->risk_color;
    }

    public function setRiskColor(?string $risk_color): self
    {
        $this->risk_color = $risk_color;

        return $this;
    }

    public function getRiskLevel(): ?int
    {
        return $this->risk_level;
    }

    public function setRiskLevel(?int $risk_level): self
    {
        $this->risk_level = $risk_level;

        return $this;
    }

    public function getText1(): ?string
    {
        return $this->text_1;
    }

    public function setText1(?string $text_1): self
    {
        $this->text_1 = $text_1;

        return $this;
    }

    public function getText2(): ?string
    {
        return $this->text_2;
    }

    public function setText2(?string $text_2): self
    {
        $this->text_2 = $text_2;

        return $this;
    }

    public function getBoldText1(): ?string
    {
        return $this->bold_text_1;
    }

    public function setBoldText1(?string $bold_text_1): self
    {
        $this->bold_text_1 = $bold_text_1;

        return $this;
    }

    public function getBoldText2(): ?string
    {
        return $this->bold_text_2;
    }

    public function setBoldText2(?string $bold_text_2): self
    {
        $this->bold_text_2 = $bold_text_2;

        return $this;
    }

    public function getText3(): ?string
    {
        return $this->text_3;
    }

    public function setText3(?string $text_3): self
    {
        $this->text_3 = $text_3;

        return $this;
    }

    public function getText4(): ?string
    {
        return $this->text_4;
    }

    public function setText4(?string $text_4): self
    {
        $this->text_4 = $text_4;

        return $this;
    }

    public function getText5(): ?string
    {
        return $this->text_5;
    }

    public function setText5(?string $text_5): self
    {
        $this->text_5 = $text_5;

        return $this;
    }

    public function getText6(): ?string
    {
        return $this->text_6;
    }

    public function setText6(?string $text_6): self
    {
        $this->text_6 = $text_6;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->update_date;
    }

    public function setUpdateDate(\DateTimeInterface $update_date): self
    {
        $this->update_date = $update_date;

        return $this;
    }

    public function getHazardCode(): ?int
    {
        return $this->hazard_code;
    }

    public function setHazardCode(?int $hazard_code): self
    {
        $this->hazard_code = $hazard_code;

        return $this;
    }

    public function getText21(): ?string
    {
        return $this->text21;
    }

    public function setText21(?string $text21): self
    {
        $this->text21 = $text21;

        return $this;
    }

    public function getText22(): ?string
    {
        return $this->text22;
    }

    public function setText22(?string $text22): self
    {
        $this->text22 = $text22;

        return $this;
    }

    public function getText23(): ?string
    {
        return $this->text23;
    }

    public function setText23(?string $text23): self
    {
        $this->text23 = $text23;

        return $this;
    }

    public function getText24(): ?string
    {
        return $this->text24;
    }

    public function setText24(?string $text24): self
    {
        $this->text24 = $text24;

        return $this;
    }

    public function getText25(): ?string
    {
        return $this->text25;
    }

    public function setText25(?string $text25): self
    {
        $this->text25 = $text25;

        return $this;
    }

    public function getText26(): ?string
    {
        return $this->text26;
    }

    public function setText26(?string $text26): self
    {
        $this->text26 = $text26;

        return $this;
    }
}
