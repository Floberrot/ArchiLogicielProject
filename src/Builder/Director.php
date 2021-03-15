<?php

namespace App\Builder;

use App\Builder\CarBuilder;
use App\Builder\UtilityVehicleBuilder;
use App\Entity\UtilityVehicle;
use App\Entity\Vehicle;

class Director
{
    public function buildVehicle($type)
    {
//         $builder->setLabel();
//         $builder->setBrand();
//         $builder->setConceptionDate();
//         $builder->setLastControl();
//         $builder->setFuel();
//         $builder->setLicence();

        switch ($type)
        {
            case ("Car"):
                return $car = new CarBuilder(new Vehicle);
            case ("UtilityVehicle"):
                return $car = new UtilityVehicleBuilder(new UtilityVehicle);
            default: "Error";
        }

//        return $builder->getCar();
    }
}