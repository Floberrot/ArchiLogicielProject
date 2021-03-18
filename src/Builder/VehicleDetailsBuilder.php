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
     * @param mixed $vehicleEnity
     * @param mixed $arrayOfVehicles
     */
    public function detailsBuilder($vehicleEntity, $arrayOfVehicles, $idDetails)
    {
        // Set un véhicule standard
        $arrayOfVehicles['label'] = $vehicleEntity->getLabel();
        $arrayOfVehicles['brand'] = $vehicleEntity->getBrand();
        $arrayOfVehicles['licence'] = $vehicleEntity->getLicence();
        $arrayOfVehicles['conception_date'] = $vehicleEntity->getConceptionDate();
        $arrayOfVehicles['last_control'] = $vehicleEntity->getLastControl();
        $arrayOfVehicles['fuel'] = $vehicleEntity->getFuel();
        // Si le véhicule a le champ motorcycle non vide, c'est que c'est une moto, on affiche donc ces données
        if ($vehicleEntity->getMotocycle()) $this->detailsMotorcycle($idDetails);
        // Idem pour un véhicule utilitaire.
        if ($vehicleEntity->getUtilityVehicle()) $this->detailsUtilityVehicle($idDetails);
    }

    /**
     * @param mixed $idDetails
     */
    public  function detailsMotorcycle($idDetails)
    {
        $moto = new Motorcycle();
        $moto = $this->motorcycleRepository->findOneBy(['vehicle' => $idDetails]);
        $dataOfVehicles['helmet_available'] = $moto->getHelmetAvailable();
    }

    /**
     * @param mixed $idDetails
     */
    public function detailsUtilityVehicle($idDetails)
    {
        $utilityVehicle = new UtilityVehicle();
        $utilityVehicle = $this->utilityVehicleRepository->findOneBy(['vehicle' => $idDetails]);
        $dataOfVehicles['max_load'] = $utilityVehicle->getMaxLoad();
        $dataOfVehicles['trunk_capacity'] = $utilityVehicle->getTrunkCapacity();
    }
}