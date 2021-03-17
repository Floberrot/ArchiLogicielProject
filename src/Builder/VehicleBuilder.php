<?php

namespace App\Builder;

use App\Entity\Motorcycle;
use App\Entity\UtilityVehicle;
use App\Entity\Vehicle;

/**
 * Class VehicleBuilder
 * @package App\Builder
 */
class VehicleBuilder
{
    static function createVehicle($res, $entityManager): Vehicle
    {
        $vehicle = new Vehicle();
        $vehicle->setLabel($res["ResultLabel"])
                ->setBrand($res["ResultBrand"])
                ->setConceptionDate($res["ResultConceptionDate"])
                ->setLastControl($res["ResultLastControl"])
                ->setFuel($res["ResultFuel"])
                ->setLicence($res["ResultLicence"]);
        $entityManager->persist($vehicle);

        $vehicleTypeBuilder = new VehicleTypeBuilder($entityManager);
        $checkVehicleType = $vehicleTypeBuilder->vehicleType($res, $vehicle);


        return $vehicle;
    }
}