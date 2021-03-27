<?php


namespace App\Builder;


use App\Entity\Motorcycle;
use Doctrine\ORM\EntityManagerInterface;

class MotorcycleBuilder
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Créer le type Moto
     * @param $res
     * @param $vehicle
     * @return Motorcycle
     */
    public function createMotorcycle($res, $vehicle): Motorcycle
    {
        $motorcycle = new Motorcycle();
        $motorcycle
            ->setVehicle($vehicle)
            ->setHelmetAvailable($res["helmetAvailable"]);
        $this->entityManager->persist($motorcycle);
        return $motorcycle;
    }
}