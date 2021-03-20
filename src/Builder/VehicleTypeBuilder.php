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

    /**
     * Crée le véhicule associé au type que le formulaire nous renvoie
     * @param $res
     * @param $vehicle
     * @return Motorcycle|UtilityVehicle
     */
    public function determineVehicleType($res, $vehicle)
    {
        if ($res["type"] === "UtilityVehicle") {
            return $this->createUtilityVehicle($res, $vehicle);
        } else if ($res["type"] === "Motorcycle") {
            return $this->createMotorcycle($res, $vehicle);
        }
    }


    /**
     * Crée le type utilityVehicule
     * @param $res
     * @param $vehicle
     * @return UtilityVehicle
     */
    public function createUtilityVehicle($res, $vehicle): UtilityVehicle
    {
        $utilityVehicle = new UtilityVehicle();
        $utilityVehicle
            ->setVehicle($vehicle)
            ->setMaxLoad($res["resultMaxLoad"])
            ->setTrunkCapacity($res["resultTrunkCapacity"]);
        $this->entityManager->persist($utilityVehicle);
        return $utilityVehicle;
    }

    /**
     * Crée le type Moto
     * @param $res
     * @param $vehicle
     * @return Motorcycle
     */
    public function createMotorcycle($res, $vehicle): Motorcycle
    {
        $motorcycle = new Motorcycle();
        $motorcycle
            ->setVehicle($vehicle)
            ->setHelmetAvailable($res["resultAccessories"]);
        $this->entityManager->persist($motorcycle);
        return $motorcycle;
    }

}
