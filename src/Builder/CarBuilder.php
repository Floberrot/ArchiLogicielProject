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

    public function setLabel()
    {
        $this->vehicle->label = "Label du véhicule";
    }

    // public function setBrand()
    // {
    //     $this->vehicle->brand = "Marque du véhicule";
    // }

    // public function setConceptionDate()
    // {
    //     $this->vehicle->ConceptionDate =  "Année de concéption du véhicule";
    // }

    // public function setLastControl()
    // {
    //     $this->vehicle->lastControl = "Date du dernier controle technique du véhicule";
    // }

    // public function setFuel()
    // {
    //     $this->vehicle->fuel = "Carburant du véhicule";
    // }

    // public function setLicence()
    // {
    //     $this->vehicle->licence = "Permis du véhicule";
    // }

    // public function setLicenceType()
    // {
    //     $this->vehicle->licenceType = "Type de permis du véhicule";
    // }

    public function getCar()
    {
        return $this->vehicle;
    }

}