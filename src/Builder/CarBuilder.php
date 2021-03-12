<?php

namespace App\Builder;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Vehicle as Vehicle;

class CarBuilder extends Vehicle implements IVehicleBuilder
{
    private $vehicle;

    public function setLabel($label)
    {
        $this->vehicle->setLabel($label);
    }

    public function setBrand($brand)
    {
        $this->vehicle->setBrand($brand);
    }

    public function setConceptionDate($conceptionDate)
    {
        $this->vehicle->setConceptionDate($conceptionDate);
    }

    public function setLastControl($lastControl)
    {
        $this->vehicle->setLastControl($lastControl);
    }

    public function setFuel($fuel)
    {
        $this->vehicle->setFuel($fuel);
    }

    public function setLicence($licence)
    {
        $this->vehicle->setLicence($licence);
    }

    public function setLicenceType($licenceType)
    {
        $this->vehicle->setLicenceType($licenceType);
    }

    public function getCar()
    {
        return $this->vehicle;
    }

}