<?php

namespace App\Controller;

use App\Builder\VehicleBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\Director;
use App\Builder\CarBuilder;
use App\Builder\UtilityVehicleBuilder;
use App\Entity\Vehicle;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class ApiController extends AbstractController
{
    /**
     * Créer un nouveau Vehicule
     * @Route ("/api/vehicle", name="create_vehicle", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function createVehicle(Request $request, EntityManagerInterface $entityManager) : JsonResponse
    {
        // Résultats de la requête (Json decode à faire)
        $res = [
            "type" => "UtilityVehicle",
            "ResultLabel" => "Label",
            "ResultBrand" => "Merco",
            "ResultConceptionDate" => new \DateTime(),
            "ResultLastControl" => new \DateTime(),
            "ResultFuel" => "Diesel",
            "ResultLicence" => "Permis b",
            "resultMaxLoad" => "10.5",
            "resultTrunkCapacity" => "10.5",
        ];
        // Création d'un nouveau véhicule
        $vehicleBuilder = new VehicleBuilder();
        $vehicleBuilder->setAndCheckVehicleType($res, $entityManager);

        $entityManager->flush();

        return new JsonResponse('ok', 200, [], true);
    }


    /**
     * @param mixed $idToEdit
     * @Route("/api/vehicle/{idToEdit}", name="edit_vehicle")
     * @return JsonResponse
     */
    public function editVehicle($idToEdit, VehicleRepository $vehicleRepository, EntityManagerInterface $entityManager) : JsonResponse
    {
        $vehicleToEdit = $vehicleRepository->find($idToEdit);

        // Nous recevrons ici les résultats su Front.
        $resEdit = [
            "type" => "UtilityVehicle",
            "ResultLabel" => "Test update 45",
            "ResultBrand" => "FERRARI",
            "ResultConceptionDate" => new \DateTime(),
            "ResultLastControl" => new \DateTime(),
            "ResultFuel" => "sp95",
            "ResultLicence" => "Permis ouais",
            "resultMaxLoad" => "1000",
            "resultTrunkCapacity" => "2000.1",
        ];

        $vehicleToEdit
            ->setLabel($resEdit['ResultLabel'])
            ->setBrand($resEdit["ResultBrand"])
            ->setConceptionDate($resEdit["ResultConceptionDate"])
            ->setLastControl($resEdit["ResultLastControl"])
            ->setFuel($resEdit["ResultFuel"])
            ->setLicence($resEdit["ResultLicence"]);
        
        // Enregistre le véhicule standard.
        $entityManager->persist($vehicleToEdit);

        $moto = $vehicleToEdit->getMotorcycle();
        $utilityVehicle = $vehicleToEdit->getUtilityVehicle();
        if ($moto) {
            $moto
                ->setVehicle($vehicleToEdit)
                ->setHelmetAvailable($resEdit['helmetAvailable']);
            $entityManager->persist($moto);
        }
        if ($utilityVehicle) {
            $utilityVehicle
                ->setVehicle($vehicleToEdit)
                ->setMaxLoad($resEdit['resultMaxLoad'])
                ->setTrunkCapacity($resEdit['resultTrunkCapacity']);
            $entityManager->persist($utilityVehicle);
        }
        $entityManager->flush();

        return new JsonResponse('edit ok', 200, [], true);
    }
}
