<?php

namespace App\Controller;

use App\Builder\VehicleBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\Director;
use App\Builder\CarBuilder;
use App\Builder\UtilityVehicleBuilder;
use App\Entity\Vehicle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class ApiController extends AbstractController
{
    /**
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function getData(Request $request): array
    {
        //Récupération des données
        $data = $request->getContent();
        $type = $data['resultType'];
        $label = $data['resultLabel'];
        $brand = $data['resultBrand'];
        $conceptionDate = new \DateTime($data['resultConceptionDate']);
        $lastControl = new \DateTime($data['resultLastControl']);
        $fuel = $data['resultFuel'];
        $licence = $data['resultLicence'];

        //Création du tableau de données
        $dataArray = [
            "type" => $type,
            "label" => $label,
            "brand" => $brand,
            "conceptionDate" => $conceptionDate,
            "lastControl" => $lastControl,
            "fuel" => $fuel,
            "licence" => $licence
        ];

        //Ajoute au tableau les données nécessaires
        switch ($type) {
            case "UtilityVehicle":
                $maxLoad = $data['resultMaxLoad'];
                $trunkCapacity = $data['resultTrunkCapacity'];
                //Ajoute les données dans le tableau
                $dataArray["resultMaxLoad"] = $maxLoad;
                $dataArray["resultTrunkCapacity"] = $trunkCapacity;
                break;
            case "Motorcycle":
                $helmetAvailable = $data['resultHelmetAvailable'];
                //Ajoute les données dans le tableau
                $dataArray["resultHelmetAvailable"] = $helmetAvailable;
                break;
        }
        return $dataArray;
    }

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
}
