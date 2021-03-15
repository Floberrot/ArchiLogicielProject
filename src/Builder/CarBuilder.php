<?php

namespace App\Builder;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Vehicle;

class CarBuilder implements IVehicleBuilder
{
    private $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function setLabelBuilder($label)
    {
        $this->vehicle->label = $label;
    }

    public function setBrandBuilder($brand)
    {
        $this->vehicle->brand = $brand;
    }

    public function setConceptionDateBuilder($conceptionDate)
    {
        $this->vehicle->ConceptionDate = $conceptionDate;
    }

    public function setLastControlBuilder($lastControl)
    {
        $this->vehicle->lastControl = $lastControl;
    }

    public function setFuelBuilder($fuel)
    {
        $this->vehicle->fuel = $fuel;
    }

    public function setLicenceBuilder($licence)
    {
        $this->vehicle->licence = $licence;
    }

    public function getCar()
    {
        return $this->vehicle;
    }

}