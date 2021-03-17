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
    /**
     * Créer un nouveau véhicule standard.
     * Dans le cas ou le type est différent de "Car", on appel les fonctions du Builder
     * @param $res
     * @param $entityManager
     * @return Vehicle
     */
    static function setAndCheckVehicleType($res, $entityManager): Vehicle
    {
        $vehicle = new Vehicle();
        $vehicle->setLabel($res["ResultLabel"])
                ->setBrand($res["ResultBrand"])
                ->setConceptionDate($res["ResultConceptionDate"])
                ->setLastControl($res["ResultLastControl"])
                ->setFuel($res["ResultFuel"])
                ->setLicence($res["ResultLicence"]);
        $entityManager->persist($vehicle);

        if ($res["type"] != "Car") {
            $vehicleTypeBuilder = new VehicleTypeBuilder($entityManager);
            $vehicleTypeBuilder->determineVehicleType($res, $vehicle);
        }

        return $vehicle;
    }
}