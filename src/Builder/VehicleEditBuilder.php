<?php
namespace App\Builder;

use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;


class VehicleEditBuilder
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * Une moto est modifié dans le cas ou le véhicule a le champ motocyle qui existe
     */
    public function editMotorcycle($vehicleToEdit, &$data)
    {
        // Mise a jour de la table moto si elle existe
        $moto = $vehicleToEdit->getMotorcycle();
        if ($moto) {
            $moto
                ->setVehicle($vehicleToEdit)
                ->setHelmetAvailable($data['resultHelmetAvailable']);
            $this->entityManager->persist($moto);
        }
    }

    /**
     * Une moto est modifié dans le cas ou le véhicule a le champ motocyle qui existe
     */
    public function editUtilityVehicle($vehicleToEdit, &$data)
    {
        // Idem pour un véhicule utilitaire :)    
        dump($vehicleToEdit);    
        $utilityVehicle = $vehicleToEdit->getUtilityVehicle();
        if ($utilityVehicle) {
            $utilityVehicle
                ->setVehicle($vehicleToEdit)
                ->setMaxLoad($data['resultMaxLoad'])
                ->setTrunkCapacity($data['resultTrunkCapacity']);
            $this->entityManager->persist($utilityVehicle);
        }
    }
}