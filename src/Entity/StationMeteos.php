<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StationMeteosRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=StationMeteosRepository::class)
 * @Vich\Uploadable
 * @ApiResource(
 * 
 *     normalizationContext={"groups"={"station:read"}},
 *     denormalizationContext={"groups"={"station:write"}}
 * 
 *   
 * )
 */


 class StationMeteos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"station:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"station:read"})
     */
    private $date_creation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"station:read", "station:write"})
     */
    private $ville;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"station:read", "station:write"})
     */
    private $codepostal;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"station:read"})
     */
    private $gps_latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"station:read"})
     */
    private $gps_longitude;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"station:read"})
     */
    private $lien_photo;

    /**
     * @Vich\UploadableField(mapping="stations_images", fileNameProperty="lien_photo")
     */
    private ?File $filePhoto = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lien_donnees;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"station:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"station:read"})
     */
    private $diy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="stationMeteos")
     * @Groups({"station:read"})
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=EtatStationMeteo::class, mappedBy="stationMeteo", cascade={"persist", "remove"})
     */
    private $etatStationMeteo;

    /**
     * @ORM\OneToMany(targetEntity=Station::class, mappedBy="stationMeteos", cascade={"persist", "remove"})
     * 
     * 
     */
    private $stations;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     * 
     */
    private EmbeddedFile $photo;

    /**
     * @ORM\OneToOne(targetEntity=StationDirect::class, mappedBy="stationMeteos", cascade={"persist", "remove"})
     * @Groups({"station:read"})
     */
    private ?StationDirect $stationDirect = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MiniMaxi", mappedBy="stationMeteos", orphanRemoval=true, fetch="EAGER")
     */
    private $miniMaxis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MiniMaxiH", mappedBy="stationMeteos", orphanRemoval=true, fetch="EAGER")
     */
    private $miniMaxiHs;

    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MiniMaxiA", mappedBy="stationMeteos", orphanRemoval=true, fetch="EAGER")
     */
    private $miniMaxiA;


    public function __construct()
    {
        $this->miniMaxiHs = new ArrayCollection();
        $this->miniMaxis = new ArrayCollection();
        $this->stations = new ArrayCollection();
        $this->date_creation = new \DateTime();
        $this->photo = new EmbeddedFile();
        //$this->stationDirect = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getGpsLatitude(): ?float
    {
        return $this->gps_latitude;
    }

    public function setGpsLatitude(?float $gps_latitude): self
    {
        $this->gps_latitude = $gps_latitude;

        return $this;
    }

    public function getGpsLongitude(): ?float
    {
        return $this->gps_longitude;
    }

    public function setGpsLongitude(?float $gps_longitude): self
    {
        $this->gps_longitude = $gps_longitude;

        return $this;
    }

    public function getLienPhoto(): ?string
    {
        return $this->lien_photo;
    }

    public function setLienPhoto(?string $lien_photo): self
    {
        $this->lien_photo = $lien_photo;

        return $this;
    }

    public function getFilePhoto(): ?File
    {
        return $this->filePhoto;
    }

    public function setFilePhoto(?File $filePhoto): self
    {
        $this->filePhoto = $filePhoto;

        if ($filePhoto) {
            $this->date_creation = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getLienDonnees(): ?string
    {
        return $this->lien_donnees;
    }

    public function setLienDonnees(?string $lien_donnees): self
    {
        $this->lien_donnees = $lien_donnees;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDiy(): ?bool
    {
        return $this->diy;
    }

    public function setDiy(?bool $diy): self
    {
        $this->diy = $diy;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEtatStationMeteo(): ?EtatStationMeteo
    {
        return $this->etatStationMeteo;
    }

    public function setEtatStationMeteo(?EtatStationMeteo $etatStationMeteo): self
    {
        if ($etatStationMeteo === null && $this->etatStationMeteo !== null) {
            $this->etatStationMeteo->setStationMeteo(null);
        }

        if ($etatStationMeteo !== null && $etatStationMeteo->getStationMeteo() !== $this) {
            $etatStationMeteo->setStationMeteo($this);
        }

        $this->etatStationMeteo = $etatStationMeteo;

        return $this;
    }

    public function getStations(): Collection
    {
        return $this->stations;
    }

    public function addStation(Station $station): self
    {
        if (!$this->stations->contains($station)) {
            $this->stations[] = $station;
            $station->setStationMeteos($this);
        }

        return $this;
    }

    public function removeStation(Station $station): self
    {
        if ($this->stations->removeElement($station)) {
            // Set the owning side to null (unless already changed)
            if ($station->getStationMeteos() === $this) {
                $station->setStationMeteos(null);
            }
        }

        return $this;
    }

    public function getPhoto(): EmbeddedFile
    {
        return $this->photo;
    }

    public function setPhoto(EmbeddedFile $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getStationDirect(): ?StationDirect
    {
        return $this->stationDirect;
    }

    public function setStationDirect(?StationDirect $stationDirect): self
    {
        $this->stationDirect = $stationDirect;

        // Assurez-vous que l'autre côté de la relation est correctement défini
        if ($stationDirect !== null && $stationDirect->getStationMeteos() !== $this) {
            $stationDirect->setStationMeteos($this);
        }

        return $this;
    }

    
    public function getMiniMaxis(): Collection
    {
        return $this->miniMaxis;
    }

    public function addMiniMaxi(MiniMaxi $miniMaxi): self
    {
        if (!$this->miniMaxis->contains($miniMaxi)) {
            $this->miniMaxis[] = $miniMaxi;
            $miniMaxi->setStationMeteos($this);
        }

        return $this;
    }

    public function removeMiniMaxi(MiniMaxi $miniMaxi): self
    {
        if ($this->miniMaxis->removeElement($miniMaxi)) {
            // set the owning side to null (unless already changed)
            if ($miniMaxi->getStationMeteos() === $this) {
                $miniMaxi->setStationMeteos(null);
            }
        }

        return $this;
    }

    public function getMiniMaxiHs(): Collection
    {
        return $this->miniMaxiHs;
    }

    public function addMiniMaxiH(MiniMaxiH $miniMaxiH): self
    {
        if (!$this->miniMaxiHs->contains($miniMaxiH)) {
            $this->miniMaxiHs[] = $miniMaxiH;
            $miniMaxiH->setStationMeteos($this);
        }

        return $this;
    }

    public function removeMiniMaxiH(MiniMaxiH $miniMaxiH): self
    {
        if ($this->miniMaxiHs->removeElement($miniMaxiH)) {
            // set the owning side to null (unless already changed)
            if ($miniMaxiH->getStationMeteos() === $this) {
                $miniMaxiH->setStationMeteos(null);
            }
        }

        return $this;
    }

        public function getMiniMaxiA(): Collection
    {
        return $this->miniMaxiA;
    }

    public function addMiniMaxiA(MiniMaxiA $miniMaxiA): self
    {
        if (!$this->miniMaxiA->contains($miniMaxiA)) {
            $this->miniMaxiA[] = $miniMaxiA;
            $miniMaxiA->setStationMeteos($this);
        }

        return $this;
    }

    public function removeMiniMaxiA(MiniMaxiA $miniMaxiA): self
    {
        if ($this->miniMaxiA->removeElement($miniMaxiA)) {
            // set the owning side to null (unless already changed)
            if ($miniMaxiA->getStationMeteos() === $this) {
                $miniMaxiA->setStationMeteos(null);
            }
        }

        return $this;
    }
}
