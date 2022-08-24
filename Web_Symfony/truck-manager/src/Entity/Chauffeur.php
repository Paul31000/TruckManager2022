<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChauffeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ChauffeurRepository::class)
 */
class Chauffeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $NomPrenom;


    /**
     * @ORM\OneToOne(targetEntity=Camionstatus::class, mappedBy="chauffeur", cascade={"persist", "detach"})
     */
    private $camionstatus;

    /**
     * @ORM\OneToMany(targetEntity=PositionHistory::class, mappedBy="chauffeur")
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

    public function getNomPrenom(): ?string
    {
        return $this->NomPrenom;
    }

    public function setNomPrenom(string $NomPrenom): self
    {
        $this->NomPrenom = $NomPrenom;

        return $this;
    }


    public function __toString(): ?string
    {
        return $this->NomPrenom;
    }

    public function getCamionstatus(): ?Camionstatus
    {
        return $this->camionstatus;
    }

    public function setCamionstatus(?Camionstatus $camionstatus): self
    {
        // unset the owning side of the relation if necessary
        if ($camionstatus === null && $this->camionstatus !== null) {
            $this->camionstatus->setChauffeur(null);
        }

        // set the owning side of the relation if necessary
        if ($camionstatus !== null && $camionstatus->getChauffeur() !== $this) {
            $camionstatus->setChauffeur($this);
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
            $positionHistory->setChauffeur($this);
        }

        return $this;
    }

    public function removePositionHistory(PositionHistory $positionHistory): self
    {
        if ($this->positionHistories->removeElement($positionHistory)) {
            // set the owning side to null (unless already changed)
            if ($positionHistory->getChauffeur() === $this) {
                $positionHistory->setChauffeur(null);
            }
        }

        return $this;
    }
}
