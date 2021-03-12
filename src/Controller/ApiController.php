<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\Director;
use App\Builder\CarBuilder;
use App\Builder\UtilityVehicleBuilder;

class ApiController extends AbstractController
{
    /**
     * @Route ("/api", name="api")
     * @param CarBuilder $carBuilder
     * @param UtilityVehicleBuilder $utilityVehicleBuilder
     * @return JsonResponse
     */
    public function index(CarBuilder $carBuilder, UtilityVehicleBuilder $utilityVehicleBuilder) : JsonResponse
    {
        $director = new Director($carBuilder, $utilityVehicleBuilder);
        $ouais = $director->buildVehicle('Car');
        $res= $ouais->setLabel('tg luca');
        return new JsonResponse([
            'ouais' => $ouais,
            'res' => $res
        ], 200, [], false);
    }
}
