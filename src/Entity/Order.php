<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private bool $isCompleted = false;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToOne(targetEntity:"Fleet", inversedBy:"order")]
    #[ORM\JoinColumn(name:"fleet_id",referencedColumnName:"id", nullable:false)]
    private Fleet $fleet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsCompleted(): bool
    {
        return $this->isCompleted;
    }

    public function setCompleted(bool $isCompleted): static
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFleet(): Fleet
    {
        return $this->fleet;
    }

    public function setFleet(Fleet $fleet): static
    {
        $this->fleet = $fleet;

        return $this;
    }

    public function __toString():string
    {
        return $this->getId();
    }
}
