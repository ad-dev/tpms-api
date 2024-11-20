<?php

namespace App\Entity;

use App\Enum\FleetStatusEnum;
use App\Repository\FleetRepository;
use Doctrine\DBAL\Schema\UniqueConstraint;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FleetRepository::class)]
#[UniqueConstraint(name: "drivers", columns: ["first_driver_id","second_driver_id"])]
class Fleet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', enumType: FleetStatusEnum::class)]
    private FleetStatusEnum $status = FleetStatusEnum::Free;

    #[ORM\OneToOne(targetEntity:"Driver", inversedBy:"firstDriver")]   
    private ?Driver $firstDriver = null;

    #[ORM\OneToOne(targetEntity:"Driver", inversedBy:"secondDriver")]
    private ?Driver $secondDriver = null;

    #[ORM\OneToOne(targetEntity:"Truck", inversedBy:"fleet")]
    #[ORM\JoinColumn(name:"truck_id",referencedColumnName:"id", nullable:false)]
    private Truck $truck;

    #[ORM\OneToOne(targetEntity:"Trailer", inversedBy:"fleet")]
    #[ORM\JoinColumn(name:"trailer_id",referencedColumnName:"id", nullable:false)]
    private Trailer $trailer;

    #[ORM\OneToOne(targetEntity: 'Order', mappedBy:'fleet')]
    private $order;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): FleetStatusEnum
    {
        return $this->status;
    }

    public function setStatus(FleetStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getFirstDriver(): ?Driver
    {
        return $this->firstDriver;
    }

    public function setFirstDriver(Driver $driver): static
    {
        $this->firstDriver = $driver;

        return $this;
    }

    public function getSecondDriver(): ?Driver
    {
        return $this->secondDriver;
    }

    public function setSecondDriver(Driver $driver): static
    {
        $this->secondDriver = $driver;

        return $this;
    }


    public function getTruck(): Truck
    {
        return $this->truck;
    }

    public function setTruck(Truck $truck): static
    {
        $this->truck = $truck;

        return $this;
    }

    public function getTrailer(): Trailer
    {
        return $this->trailer;
    }

    public function setTrailer(Trailer $trailer): static
    {
        $this->trailer = $trailer;

        return $this;
    }
}
