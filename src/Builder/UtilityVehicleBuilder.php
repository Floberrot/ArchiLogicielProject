<?php


namespace App\Builder;


use App\Entity\UtilityVehicle;
use Doctrine\ORM\EntityManagerInterface;

class UtilityVehicleBuilder
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Créer le type utilityVehicle
     * @param $res
     * @param $vehicle
     * @return UtilityVehicle
     */
    public function createUtilityVehicle($res, $vehicle): UtilityVehicle
    {
        $utilityVehicle = new UtilityVehicle();
        $utilityVehicle
            ->setVehicle($vehicle)
            ->setMaxLoad($res["maxLoad"])
            ->setTrunkCapacity($res["trunkCapacity"]);
        $this->entityManager->persist($utilityVehicle);
        return $utilityVehicle;
    }
}