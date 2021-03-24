<?php

namespace App\Builder;

use App\Entity\Motorcycle;
use App\Entity\UtilityVehicle;
use App\Repository\MotorcycleRepository;
use App\Repository\UtilityVehicleRepository;

/**
 * Class VehicleDetailsBuilder
 * @package App\Builder
 */
class VehicleDetailsBuilder
{
    private $motorcycleRepository;
    private $utilityVehicleRepository;

    public function __construct(MotorcycleRepository $motorcycleRepository, UtilityVehicleRepository $utilityVehicleRepository)
    {
        $this->motorcycleRepository = $motorcycleRepository;   
        $this->utilityVehicleRepository = $utilityVehicleRepository;
    }

    /**
     * Cette fonction set les valeurs standard d'un véhicule dans un tableau.
     * Dans le cas ou le véhicule est "spécial" on set les champs associés.
     * @param mixed $vehicleEnity
     * @param mixed $arrayOfVehicles
     */
    public function detailsBuilder($vehicleEntity, &$arrayOfVehicles, $idDetails)
    {
        // Set un véhicule standard
        $arrayOfVehicles['label'] = $vehicleEntity->getLabel();
        $arrayOfVehicles['brand'] = $vehicleEntity->getBrand();
        $arrayOfVehicles['licence'] = $vehicleEntity->getLicence();
        $arrayOfVehicles['conception_date'] = $vehicleEntity->getConceptionDate();
        $arrayOfVehicles['last_control'] = $vehicleEntity->getLastControl();
        $arrayOfVehicles['fuel'] = $vehicleEntity->getFuel();
        $arrayOfVehicles['description'] = $vehicleEntity->getDescription();

        // Si le véhicule a le champ motorcycle non vide, c'est que c'est une moto, on affiche donc ces données
        if ($vehicleEntity->getMotorcycle()) {
            $this->detailsMotorcycle($idDetails, $arrayOfVehicles);
        }
        // Idem pour un véhicule utilitaire.
        if ($vehicleEntity->getUtilityVehicle()) {
            $this->detailsUtilityVehicle($idDetails, $arrayOfVehicles);
        }
    }

    /**
     * Set les champs d'une moto dans un tableau
     * @param mixed $idDetails
     */
    public function detailsMotorcycle($idDetails, &$arrayOfVehicles)
    {
        $moto = new Motorcycle();
        $moto = $this->motorcycleRepository->findOneBy(['vehicle' => $idDetails]);
        $arrayOfVehicles['helmet_available'] = $moto->getHelmetAvailable();
        $arrayOfVehicles['type'] = 'Motorcycle';
    }

    /**
     * Set les champs d'un véhicule utilitaire dans un tableau.
     * @param mixed $idDetails
     */
    public function detailsUtilityVehicle($idDetails, &$arrayOfVehicles)
    {
        $utilityVehicle = new UtilityVehicle();
        $utilityVehicle = $this->utilityVehicleRepository->findOneBy(['vehicle' => $idDetails]);
        $arrayOfVehicles['max_load'] = $utilityVehicle->getMaxLoad();
        $arrayOfVehicles['trunk_capacity'] = $utilityVehicle->getTrunkCapacity();
        $arrayOfVehicles['type'] = 'UtilityVehicle';
    }
}