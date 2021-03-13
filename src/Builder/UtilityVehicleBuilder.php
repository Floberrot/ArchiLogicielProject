<?php

namespace App\Builder;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Vehicle;

class UtilityVehicleBuilder implements IVehicleBuilder
{
    private $utilityVehicle;

    public function __construct(Vehicle $utilityVehicle)
    {
        $this->utilityVehicle = $utilityVehicle;
    }

    public function setLabel()
    {
        $this->utilityVehicle->label = "Label du véhicule utilitaire";
    }

    // public function setBrand()
    // {
    //     $this->utilityVehicle->brand = "Marque du véhicule utilitaire";
    // }

    // public function setConceptionDate()
    // {
    //     $this->utilityVehicle->ConceptionDate =  "Année de concéption du véhicule utilitaire";
    // }

    // public function setLastControl()
    // {
    //     $this->utilityVehicle->lastControl = "Date du dernier controle technique du véhicule utilitaire";
    // }

    // public function setFuel()
    // {
    //     $this->utilityVehicle->fuel = "Carburant du véhicule utilitaire";
    // }

    // public function setLicence()
    // {
    //     $this->utilityVehicle->licence = "Permis du véhicule utilitaire";
    // }

    // public function setLicenceType()
    // {
    //     $this->utilityVehicle->licenceType = "Type de permis du véhicule utilitaire";
    // }

    public function getCar()
    {
        return $this->utilityVehicle;
    }

}