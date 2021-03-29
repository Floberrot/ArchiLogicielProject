<?php

namespace App\Builder;

use App\Entity\Motorcycle;
use App\Entity\UtilityVehicle;
use App\Entity\Vehicle;
use App\Repository\MotorcycleRepository;
use App\Repository\UtilityVehicleRepository;
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


    /**
     * Cette fonction set les valeurs standard d'un véhicule dans un tableau.
     * Dans le cas ou le véhicule est "spécial" on set les champs associés.
     * @param $vehicleEntity
     * @param mixed $arrayOfVehicles
     * @param $idDetails
     * @param EntityManagerInterface $entityManager
     * @param MotorcycleRepository $motorcycleRepository
     * @param UtilityVehicleRepository $utilityVehicleRepository
     */
    public function detailsBuilder($vehicleEntity, &$arrayOfVehicles, $idDetails, EntityManagerInterface $entityManager, MotorcycleRepository $motorcycleRepository, UtilityVehicleRepository $utilityVehicleRepository)
    {
        // Set un véhicule standard
        $arrayOfVehicles['label'] = $vehicleEntity->getLabel();
        $arrayOfVehicles['brand'] = $vehicleEntity->getBrand();
        $arrayOfVehicles['licence'] = $vehicleEntity->getLicence();
        $arrayOfVehicles['conception_date'] = date_format($vehicleEntity->getConceptionDate(), 'Y-m-d');
        $arrayOfVehicles['last_control'] = date_format($vehicleEntity->getLastControl(), 'Y-m-d');
        $arrayOfVehicles['fuel'] = $vehicleEntity->getFuel();
        $arrayOfVehicles['description'] = $vehicleEntity->getDescription();
        $arrayOfVehicles['type'] = '';
        $arrayOfVehicles['is_public'] = $vehicleEntity->getIsPublic();
        // Si le véhicule a le champ motorcycle non vide, c'est que c'est une moto, on affiche donc ces données
        $motorcycle = new MotorcycleBuilder($entityManager);
        if ($vehicleEntity->getMotorcycle()) {
            $motorcycle->detailsMotorcycle($idDetails, $arrayOfVehicles, $motorcycleRepository);
        }
        // Idem pour un véhicule utilitaire.
        $utilityVehicle = new UtilityVehicleBuilder($entityManager);
        if ($vehicleEntity->getUtilityVehicle()) {
            $utilityVehicle->detailsUtilityVehicle($idDetails, $arrayOfVehicles, $utilityVehicleRepository);
        }
    }
}