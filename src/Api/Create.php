<?php

namespace App\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\Director;
use App\Builder\CarBuilder;
use App\Builder\UtilityVehicleBuilder;
use App\Entity\Vehicle;
use Symfony\Component\HttpFoundation\Request;

class Create
{
    /**
     * @Route ("/api/vehicle", name="api")
     * @return JsonResponse
     */
    public function createVehicle(Request $request) : JsonResponse
    {
        $director = new Director();
        $data = $request->getContent();
        $decode = json_decode($data);
        $type = 'Car';
        $label = 'test';
        $vehicle = $this->director->buildVehicle($type);
        $vehicle->setLabel($label);
        
        return new JsonResponse('ok', 200, [], true);
    }
}
