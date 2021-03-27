<?php

namespace App\Builder;

use App\Entity\Motorcycle;
use App\Entity\UtilityVehicle;
use Doctrine\ORM\EntityManagerInterface;
use App\Builder\MotorcycleBuilder;

/**
 * Class VehicleTypeBuilder
 * @package App\Builder
 */
class VehicleTypeBuilder
{
    private $entityManager;
    private $motorcycle;
    private $utilityVehicle;

    public function __construct(EntityManagerInterface $entityManager, MotorcycleBuilder $motorcycle, UtilityVehicleBuilder $utilityVehicle)
    {
        $this->entityManager = $entityManager;
        $this->motorcycle = $motorcycle;
        $this->utilityVehicle = $utilityVehicle;
    }

    /**
     * Crée le véhicule associé au type que le formulaire nous renvoie
     * @param $res
     * @param $vehicle
     * @return Motorcycle|UtilityVehicle
     */
    public function determineVehicleType($res, $vehicle)
    {
        if ($res["type"] === "UtilityVehicle") {
            return $this->utilityVehicle->createUtilityVehicle($res, $vehicle);
        } else if ($res["type"] === "Motorcycle") {
            return $this->motorcycle->createMotorcycle($res, $vehicle);
        }
    }
}
