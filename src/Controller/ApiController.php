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
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    /**
     * @Route ("/api/vehicle", name="api")
     */
    public function createVehicle(Request $request)
    {
        $director = new Director();
        $type = 'Car';
        $label = 'test';
        $vehicle = $director->buildVehicle($type);
        $vehicle->setLabel($label);
        
    }
}
