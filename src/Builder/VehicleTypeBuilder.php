<?php

namespace App\Builder;

use App\Entity\Motorcycle;
use App\Entity\UtilityVehicle;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class VehicleTypeBuilder
 * @package App\Builder
 */
class VehicleTypeBuilder
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function vehicleType($res, $vehicle)
    {
        if($res["type"] === "UtilityVehicle") {
            return $this->createUtilityVehicle($res, $vehicle);
        } else if($res["type"] === "Motorcycle") {
            return $this->createMotorcycle($res, $vehicle);
        }
    }

    public function createUtilityVehicle($res, $vehicle): UtilityVehicle
    {
        $utilityVehicle = new UtilityVehicle();
        $utilityVehicle->setVehicle($vehicle)
                ->setMaxLoad($res["resultMaxLoad"])
                ->setTrunkCapacity($res["resultTrunkCapacity"]);
        $this->entityManager->persist($utilityVehicle);
        return $utilityVehicle;
    }

    public function createMotorcycle($res, $vehicle): Motorcycle
    {
        $motorcycle = new Motorcycle();
        $motorcycle->setVehicle($vehicle)
                ->setAccessories($res["resultAccessories"]);
        $this->entityManager->persist($motorcycle);
        return $motorcycle;
    }
}
