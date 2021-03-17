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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class ApiController extends AbstractController
{
    /**
     * @Route ("/api/vehicle", name="api")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function createVehicle(Request $request, EntityManagerInterface $entityManager) : JsonResponse
    {
        $res = [
            "type" => "Car",
            "ResultLabel" => "Label",
            "ResultBrand" => "Merco",
            "ResultConceptionDate" => (\DateTime::createFromFormat('Y-m-d', "2018-09-09")),
            "ResultLastControl" => (\DateTime::createFromFormat('Y-m-d', "2018-09-09")),
            "ResultFuel" => "Diesel",
            "ResultLicence" => "Permis b",
            "resultAccessories" => true,
        ];

        $vehicleBuilder = new VehicleBuilder();
        $vehicleBuilder->createVehicle($res, $entityManager);

        $entityManager->flush();

        return new JsonResponse('ok', 200, [], true);
    }
}
