<?php

namespace App\Entity;

use App\Repository\UtilityVehicleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilityVehicleRepository::class)
 */
class UtilityVehicle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Vehicle::class, inversedBy="utilityVehicle", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    /**
     * @ORM\Column(type="float")
     */
    private $max_load;

    /**
     * @ORM\Column(type="float")
     */
    public $trunk_capacity;

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

    public function getMaxLoad(): ?float
    {
        return $this->max_load;
    }

    public function setMaxLoad(float $max_load): self
    {
        $this->max_load = $max_load;

        return $this;
    }

    public function getTrunkCapacity(): ?float
    {
        return $this->trunk_capacity;
    }

    public function setTrunkCapacity(float $trunk_capacity): self
    {
        $this->trunk_capacity = $trunk_capacity;

        return $this;
    }
}
