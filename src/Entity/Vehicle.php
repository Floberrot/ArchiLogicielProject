<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 */
class Vehicle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    //J'ai passé la variable en public pour la portabilité de cette variable
    public $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brand;

    /**
     * @ORM\Column(type="datetime")
     */
    private $conception_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_control;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fuel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $licence;

    /**
     * @ORM\OneToOne(targetEntity=UtilityVehicle::class, mappedBy="vehicle", cascade={"persist", "remove"})
     */
    private $utilityVehicle;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getConceptionDate(): ?\DateTimeInterface
    {
        return $this->conception_date;
    }

    public function setConceptionDate(\DateTimeInterface $conception_date): self
    {
        $this->conception_date = $conception_date;

        return $this;
    }

    public function getLastControl(): ?\DateTimeInterface
    {
        return $this->last_control;
    }

    public function setLastControl(\DateTimeInterface $last_control): self
    {
        $this->last_control = $last_control;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getLicence(): ?string
    {
        return $this->licence;
    }

    public function setLicence(string $licence): self
    {
        $this->licence = $licence;

        return $this;
    }

    public function getUtilityVehicle(): ?UtilityVehicle
    {
        return $this->utilityVehicle;
    }

    public function setUtilityVehicle(UtilityVehicle $utilityVehicle): self
    {
        // set the owning side of the relation if necessary
        if ($utilityVehicle->getVehicle() !== $this) {
            $utilityVehicle->setVehicle($this);
        }

        $this->utilityVehicle = $utilityVehicle;

        return $this;
    }
}
