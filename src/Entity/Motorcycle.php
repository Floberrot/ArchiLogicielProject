<?php

namespace App\Entity;

use App\Repository\MotorcycleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MotorcycleRepository::class)
 */
class Motorcycle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Vehicle::class, inversedBy="accessories", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $helmetAvailable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getHelmetAvailable(): ?bool
    {
        return $this->helmetAvailable;
    }

    public function setHelmetAvailable(?bool $helmetAvailable): self
    {
        $this->helmetAvailable = $helmetAvailable;

        return $this;
    }
}
