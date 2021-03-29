<?php


namespace App\Builder;


use App\Entity\Motorcycle;
use App\Repository\MotorcycleRepository;
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

    /**
     * Une moto est modifiée dans le cas ou le véhicule a le champ motorcycle qui existe
     * @param $vehicleToEdit
     * @param $data
     */
    public function editMotorcycle($vehicleToEdit, &$data)
    {
        // Mise a jour de la table moto si elle existe
        $moto = $vehicleToEdit->getMotorcycle();
        if ($moto) {
            $moto
                ->setVehicle($vehicleToEdit)
                ->setHelmetAvailable($data['helmetAvailable']);
            $this->entityManager->persist($moto);
        }
    }


    /**
     * Set les champs d'une moto dans un tableau
     * @param mixed $idDetails
     * @param $arrayOfVehicles
     * @param MotorcycleRepository $motorcycleRepository
     */
    public function detailsMotorcycle($idDetails, &$arrayOfVehicles, MotorcycleRepository $motorcycleRepository)
    {
        $moto = new Motorcycle();
        $moto = $motorcycleRepository->findOneBy(['vehicle' => $idDetails]);
        $arrayOfVehicles['helmet_available'] = $moto->getHelmetAvailable();
        $arrayOfVehicles['type'] = 'Motorcycle';
    }
}