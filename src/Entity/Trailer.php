<?php

namespace App\Entity;

use App\Repository\TrailerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrailerRepository::class)]
class Trailer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64, unique: true)]
    private ?string $PlateNo = null;

    #[ORM\OneToOne(targetEntity: 'Fleet', mappedBy:'trailer')]
    private $fleet;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlateNo(): ?string
    {
        return $this->PlateNo;
    }

    public function setPlateNo(string $PlateNo): static
    {
        $this->PlateNo = $PlateNo;

        return $this;
    }
}
