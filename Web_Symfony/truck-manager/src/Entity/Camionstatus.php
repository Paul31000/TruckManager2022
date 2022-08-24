<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CamionstatusRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Chauffeur;
use App\Entity\Camion;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CamionstatusRepository::class)
 */
class Camionstatus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enPanne;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enPause;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $arrive;

    /**
     * @ORM\OneToOne(targetEntity=camion::class, inversedBy="camionstatus", cascade={"persist", "detach"})
     */
    private $camion;

    /**
     * @ORM\OneToOne(targetEntity=Chauffeur::class, inversedBy="camionstatus", cascade={"persist", "detach"})
     */
    private $chauffeur;

    public function getId(): ?float
    {
        return $this->id;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getEnPanne(): ?bool
    {
        return $this->enPanne;
    }

    public function setEnPanne(?bool $enPanne): self
    {
        $this->enPanne = $enPanne;

        return $this;
    }

    public function getEnPause(): ?bool
    {
        return $this->enPause;
    }

    public function setEnPause(?bool $enPause): self
    {
        $this->enPause = $enPause;

        return $this;
    }

    public function getArrive(): ?bool
    {
        return $this->arrive;
    }

    public function setArrive(?bool $arrive): self
    {
        $this->arrive = $arrive;

        return $this;
    }

    public function getCamion(): ?camion
    {
        return $this->camion;
    }

    public function setCamion(?camion $camion): self
    {
        $this->camion = $camion;

        return $this;
    }

    public function getChauffeur(): ?Chauffeur
    {
        return $this->chauffeur;
    }

    public function setChauffeur(?Chauffeur $chauffeur): self
    {
        $this->chauffeur = $chauffeur;

        return $this;
    }
}
