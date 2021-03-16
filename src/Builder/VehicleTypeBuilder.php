<?php

namespace App\Builder;

use App\Entity\Motorcycle;
use App\Entity\UtilityVehicle;

/**
 * Class VehicleTypeBuilder
 * @package App\Builder
 */
class VehicleTypeBuilder
{
    static function vehicleType($res)
    {
        if($res["type"] === "UtilityVehicle") {
            return VehicleTypeBuilder::createUtilityVehicle($res);
        } else if($res["type"] === "Motorcycle") {
            return VehicleTypeBuilder::createMotorcycle($res);
        }
    }

    static function createUtilityVehicle($res): UtilityVehicle
    {
        $vehicle = new UtilityVehicle();
        $vehicle->setMaxLoad($res["resultMaxLoad"])
                ->setTrunkCapacity($res["resultTrunkCapacity"]);
        return $vehicle;
    }

    static function createMotorcycle($res): Motorcycle
    {
        $vehicle = new Motorcycle();
        $vehicle->setAccessories($res["resultAccessories"]);
//        dump($vehicle);
        return $vehicle;
    }
}
