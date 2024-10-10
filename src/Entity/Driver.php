<?php

namespace App\Entity;

use App\Repository\DriverRepository;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: DriverRepository::class)]
#[UniqueConstraint(name: "name", columns: ["name","last_name"])]
class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $Name = null;

    #[ORM\Column(length: 128)]
    private ?string $LastName = null;

    #[ORM\OneToOne(targetEntity: 'Fleet', mappedBy:'firstDriver')]
    private $firstDriver;

    #[ORM\OneToOne(targetEntity: 'Fleet', mappedBy:'secondDriver')]
    private $secondDriver;

    #[Ignore]
    public function getFirstDriver(): void
    {
        
    }
    #[Ignore]
    public function getSecondDriver(): void
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }
}
