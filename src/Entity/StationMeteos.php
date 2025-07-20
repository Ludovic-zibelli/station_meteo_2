<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StationMeteosRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Embedded;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;



/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=StationMeteosRepository::class)
 * @Vich\Uploadable
 */
class StationMeteos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="integer")
     */
    private $codepostal;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $gps_latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $gps_longitude;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lien_photo;

    
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @var File|null
     * 
     * @Vich\UploadableField(mapping="stations_images", fileNameProperty="lien_photo")
     */
    private $filePhoto;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lien_donnees;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $diy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="stationMeteos")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=StationDirect::class, mappedBy="station", cascade={"persist", "remove"})
     */
    private $stationDirect;

    /**
     * @ORM\OneToOne(targetEntity=Station::class, mappedBy="idStationMeteo", cascade={"persist", "remove"})
     */
    private $station;

    /**
     * @ORM\OneToOne(targetEntity=EtatStationMeteo::class, mappedBy="station_meteo", cascade={"persist", "remove"})
     */
    private $etatStationMeteo;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    private $photo;

    public function __construct()
    {
        //$this->user = new ArrayCollection();
        $this->date_creation = new \DateTime();
        $this->photo = new Embedded();
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

  
  
    public function getLienPhoto(): ?String
    {
        return $this->lien_photo;
    }


    public function setLienPhoto(?string $lien_photo): self
    {
        $this->lien_photo  = $lien_photo ;

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

    public function getStationDirect(): ?StationDirect
    {
        return $this->stationDirect;
    }

    public function setStationDirect(StationDirect $stationDirect): self
    {
        // set the owning side of the relation if necessary
        if ($stationDirect->getStationMeteos() !== $this) {
            $stationDirect->setStationMeteos($this);
        }

        $this->stationDirect = $stationDirect;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        // unset the owning side of the relation if necessary
        if ($station === null && $this->station !== null) {
            $this->station->setidStationMeteo(null);
        }

        // set the owning side of the relation if necessary
        if ($station !== null && $station->getidStationMeteo() !== $this) {
            $station->setidStationMeteo($this);
        }

        $this->station = $station;

        return $this;
    }

    public function getEtatStationMeteo(): ?EtatStationMeteo
    {
        return $this->etatStationMeteo;
    }

    public function setEtatStationMeteo(?EtatStationMeteo $etatStationMeteo): self
    {
        // unset the owning side of the relation if necessary
        if ($etatStationMeteo === null && $this->etatStationMeteo !== null) {
            $this->etatStationMeteo->setStationMeteo(null);
        }

        // set the owning side of the relation if necessary
        if ($etatStationMeteo !== null && $etatStationMeteo->getStationMeteo() !== $this) {
            $etatStationMeteo->setStationMeteo($this);
        }

        $this->etatStationMeteo = $etatStationMeteo;

        return $this;
    }

        /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|null $filePhoto
     * 
     */
    public function setFilePhoto(?File $filePhoto = null)
    {
        $this->filePhoto  = $filePhoto ;

        if (null !== $filePhoto ) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->date_creation = new \DateTimeImmutable();
        }
    }


    /**
     * @return File|null
     * 
     */
    public function getFilePhoto(): ?File
    {
        return $this->filePhoto;
    }

    
    public function setPhoto(EmbeddedFile $photo): void
    {
        $this->photo = $photo;
    }

    public function getPhoto(): ?EmbeddedFile
    {
        return $this->photo;
    }
    

   
  
}
