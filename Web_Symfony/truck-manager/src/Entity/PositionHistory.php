<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PositionHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PositionHistoryRepository::class)
 */
class PositionHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
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
     * @ORM\ManyToOne(targetEntity=Camion::class, inversedBy="positionHistories")
     */
    private $camion;

    /**
     * @ORM\ManyToOne(targetEntity=Chauffeur::class, inversedBy="positionHistories")
     */
    private $chauffeur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
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

    public function getCamion(): ?Camion
    {
        return $this->camion;
    }

    public function setCamion(?Camion $camion): self
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
