<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\Director;
use App\Builder\CarBuilder;
use App\Builder\UtilityVehicleBuilder;
use App\Entity\Vehicle;

class ApiController extends AbstractController
{
    /**
     * @Route ("/api", name="api")
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $type = "UtilityVehicle";
        $director = new Director();

        // if ($type === "Car"){
        //     $car = $director->buildVehicle(new CarBuilder(new Vehicle));
        //     dump("car");
        // } elseif ($type === "UtilityVehicle") {
        //     $car = $director->buildVehicle(new UtilityVehicleBuilder(new Vehicle));
        //     dump("car utilitaire");
        // }

        switch ($type)
        {
            case ("Car"):
                $car = $director->buildVehicle(new CarBuilder(new Vehicle));
                dump("car");
                break;
            case ("UtilityVehicle"):
                $car = $director->buildVehicle(new UtilityVehicleBuilder(new Vehicle));
                dump("car utilitaire");
                break;
            default: "Error";
        }

        return new JsonResponse([
            'label' => $car->label,
        ], 200, [], false);
    }
}
