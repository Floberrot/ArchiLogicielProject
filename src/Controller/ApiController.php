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
use App\Entity\Motorcycle;
use App\Entity\UtilityVehicle;
use App\Entity\Vehicle;
use App\Repository\MotorcycleRepository;
use App\Repository\UtilityVehicleRepository;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Json;

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
     * Cette fonction affiche tous les véhicules de la DB
     * @Route("/api/vehicle", name="showVehicles", methods={"GET"})
     * @param VehicleRepository $vehicleRepository
     * @return JsonResponse
     */
    public function showVehicles(VehicleRepository $vehicleRepository) : JsonResponse
    {
        $allVehicle = new Vehicle();
        $allVehicle = $vehicleRepository->findAll();
        $vehicleToDisplay = [];
        foreach ($allVehicle as $oneVehicle)
        {
            $label = $oneVehicle->getLabel();
            $brand = $oneVehicle->getBrand();
            $licence = $oneVehicle->getLicence();
            $dataOfVehicles['label'] = $label;
            $dataOfVehicles['brand'] = $brand;
            $dataOfVehicles['licence'] = $licence;
            
            array_push($vehicleToDisplay, $dataOfVehicles);
        }
        // Voir avec Fabien ce qu'il veut comme valeur de retour.
        return new JsonResponse(
            [
                'arrayOfVehicles' => $vehicleToDisplay
            ]
        );
    }


    /**
     * Cette fonction affiche les détails d'un seul véhicule.
     * Vérification du type si il en a un evidemment.
     * @Route("api/vehicle/{idDetails}", name="detail_vehicle", methods={"GET"})
     * @param $idDetails
     * @return JsonResponse
     */
    public function detailVehicle($idDetails, VehicleRepository $vehicleRepository, MotorcycleRepository $motorcycleRepository, UtilityVehicleRepository $utilityVehicleRepository) : JsonResponse
    {
        $detailVehicle = new Vehicle();
        $detailVehicle = $vehicleRepository->find($idDetails);
        $detailToDisplay = [];
        // A faire dans une autre fonction ? Voir builder de création
        $dataOfVehicles['label'] = $detailVehicle->getLabel();
        $dataOfVehicles['brand'] = $detailVehicle->getBrand();
        $dataOfVehicles['licence'] = $detailVehicle->getLicence();
        $dataOfVehicles['conception_date'] = $detailVehicle->getConceptionDate();
        $dataOfVehicles['last_control'] = $detailVehicle->getLastControl();
        $dataOfVehicles['fuel'] = $detailVehicle->getFuel();
        if ($detailVehicle->getMotorcycle()) {
            $moto = new Motorcycle();
            $moto = $motorcycleRepository->findOneBy(['vehicle' => $idDetails]);
            $dataOfVehicles['helmet_available'] = $moto->getHelmetAvailable();
        } else if ($detailVehicle->getUtilityVehicle()) {
            $utilityVehicle = new UtilityVehicle();
            $utilityVehicle = $utilityVehicleRepository->findOneBy(['vehicle' => $idDetails]);
            $dataOfVehicles['max_load'] = $utilityVehicle->getMaxLoad();
            $dataOfVehicles['trunk_capacity'] = $utilityVehicle->getTrunkCapacity();
        }
        // Voir avec Fabien ce qu'il veut exactement comme retour
        return new JsonResponse(
            [
                'detailVehicle' => $dataOfVehicles
            ]
            );
    }
}
