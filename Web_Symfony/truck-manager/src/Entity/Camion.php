<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CamionRepository;
use App\Entity\Chauffeur;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CamionRepository::class)
 */
class Camion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $imatriculation;

    /**
     * @ORM\OneToOne(targetEntity=Camionstatus::class, mappedBy="camion", cascade={"persist", "detach"})
     */
    private $camionstatus;

    /**
     * @ORM\OneToMany(targetEntity=PositionHistory::class, mappedBy="camion")
     */
    private $positionHistories;

    public function __construct()
    {
        $this->positionHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getImatriculation(): ?string
    {
        return $this->imatriculation;
    }

    public function setImatriculation(string $imatriculation): self
    {
        $this->imatriculation = $imatriculation;

        return $this;
    }

    public function __toString(): ?string
    {
        return $this->imatriculation;
    }

    public function getCamionstatus(): ?Camionstatus
    {
        return $this->camionstatus;
    }

    public function setCamionstatus(?Camionstatus $camionstatus): self
    {
        // unset the owning side of the relation if necessary
        if ($camionstatus === null && $this->camionstatus !== null) {
            $this->camionstatus->setCamion(null);
        }

        // set the owning side of the relation if necessary
        if ($camionstatus !== null && $camionstatus->getCamion() !== $this) {
            $camionstatus->setCamion($this);
        }

        $this->camionstatus = $camionstatus;

        return $this;
    }

    /**
     * @return Collection<int, PositionHistory>
     */
    public function getPositionHistories(): Collection
    {
        return $this->positionHistories;
    }

    public function addPositionHistory(PositionHistory $positionHistory): self
    {
        if (!$this->positionHistories->contains($positionHistory)) {
            $this->positionHistories[] = $positionHistory;
            $positionHistory->setCamion($this);
        }

        return $this;
    }

    public function removePositionHistory(PositionHistory $positionHistory): self
    {
        if ($this->positionHistories->removeElement($positionHistory)) {
            // set the owning side to null (unless already changed)
            if ($positionHistory->getCamion() === $this) {
                $positionHistory->setCamion(null);
            }
        }

        return $this;
    }
}