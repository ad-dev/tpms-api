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
    private ?string $name = null;

    #[ORM\Column(length: 128)]
    private ?string $lastName = null;

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
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): string
    {
        return implode(" ", [$this->name, $this->lastName]);
    }
}
