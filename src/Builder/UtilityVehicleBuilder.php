<?php


namespace App\Builder;


use App\Entity\UtilityVehicle;
use App\Repository\UtilityVehicleRepository;
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

    /**
     * Une moto est modifié dans le cas ou le véhicule a le champ motocyle qui existe
     * @param $vehicleToEdit
     * @param $data
     */
    public function editUtilityVehicle($vehicleToEdit, &$data)
    {
        // Idem pour un véhicule utilitaire :)
        dump($vehicleToEdit);
        $utilityVehicle = $vehicleToEdit->getUtilityVehicle();
        if ($utilityVehicle) {
            $utilityVehicle
                ->setVehicle($vehicleToEdit)
                ->setMaxLoad($data['maxLoad'])
                ->setTrunkCapacity($data['trunkCapacity']);
            $this->entityManager->persist($utilityVehicle);
        }
    }

    /**
     * Set les champs d'un véhicule utilitaire dans un tableau.
     * @param mixed $idDetails
     * @param $arrayOfVehicles
     * @param UtilityVehicleRepository $utilityVehicleRepository
     */
    public function detailsUtilityVehicle($idDetails, &$arrayOfVehicles, UtilityVehicleRepository $utilityVehicleRepository)
    {
        $utilityVehicle = $utilityVehicleRepository->findOneBy(['vehicle' => $idDetails]);
        $arrayOfVehicles['max_load'] = $utilityVehicle->getMaxLoad();
        $arrayOfVehicles['trunk_capacity'] = $utilityVehicle->getTrunkCapacity();
        $arrayOfVehicles['type'] = 'UtilityVehicle';
    }
}