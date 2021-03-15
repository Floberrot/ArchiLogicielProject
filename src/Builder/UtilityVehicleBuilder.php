<?php

namespace App\Builder;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\UtilityVehicle;
use App\Entity\Vehicle;


class UtilityVehicleBuilder implements IVehicleBuilder
{
    private $utilityVehicle;
    private $vehicle;

    public function __construct(UtilityVehicle $utilityVehicle, Vehicle $vehicle)
    {
        $this->utilityVehicle = $utilityVehicle;
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

     public function setTrunkCapacityBuilder()
     {
         $this->utilityVehicle->trunk_capacity = "Permis du véhicule utilitaire";
     }

     public function setMaxLoadBuilder()
     {
         $this->utilityVehicle->max_load = "Permis du véhicule utilitaire";
     }

    public function getCar()
    {
        return $this->utilityVehicle;
    }

}