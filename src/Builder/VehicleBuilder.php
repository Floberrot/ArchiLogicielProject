<?php

namespace App\Builder;

use App\Entity\Motorcycle;
use App\Entity\UtilityVehicle;
use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class VehicleBuilder
 * @package App\Builder
 */
class VehicleBuilder
{
    private $motorcycle;
    private $utilityVehicle;

    public function __construct(MotorcycleBuilder $motorcycle, UtilityVehicleBuilder $utilityVehicle)
    {
        $this->motorcycle = $motorcycle;
        $this->utilityVehicle = $utilityVehicle;
    }
    /**
     * Créer un nouveau véhicule standard.
     * Dans le cas ou le type est différent de "Car", on appel les fonctions du Builder
     * @param $res
     * @param $entityManager
     * @return Vehicle
     */
    public function createStandardVehicle($res, $entityManager): Vehicle
    {
        $vehicle = new Vehicle();
        $vehicle->setLabel($res["label"])
                ->setBrand($res["brand"])
                ->setConceptionDate($res["conceptionDate"])
                ->setLastControl($res["lastControl"])
                ->setFuel($res["fuel"])
                ->setLicence($res["licence"])
                ->setIsPublic(true);
        $entityManager->persist($vehicle);
        // Si le véhicule a un type, on va faire une vérification de quel est son type.
        if ($res["type"] != "") {
            $vehicleTypeBuilder = new VehicleTypeBuilder($entityManager, $this->motorcycle, $this->utilityVehicle);
            $vehicleTypeBuilder->determineVehicleType($res, $vehicle);
        }
        return $vehicle;
    }
}