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
//         return $builder->getCar();

        switch ($type)
        {
            case ("Car"):
                return $car = new CarBuilder(new Vehicle);
            case ("UtilityVehicle"):
                return $car = new UtilityVehicleBuilder(new UtilityVehicle);
            default: "Error";
        }
    }
}