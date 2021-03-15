<?php

namespace App\Builder;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\UtilityVehicle;
use App\Entity\Vehicle;


class UtilityVehicleBuilder extends Vehicle implements IVehicleBuilder 
{
    private $utilityVehicle;

    public function __construct(UtilityVehicle $utilityVehicle)
    {
        $this->utilityVehicle = $utilityVehicle;
    }

     public function setTrunkCapacity()
     {
         $this->utilityVehicle->trunk_capacity = "Permis du véhicule utilitaire";
     }

     public function setMaxLoad()
     {
         $this->utilityVehicle->max_load = "Permis du véhicule utilitaire";
     }

    public function getCar()
    {
        return $this->utilityVehicle;
    }

}