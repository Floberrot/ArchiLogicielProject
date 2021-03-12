<?php

namespace App\Builder;

use App\Builder\CarBuilder;
use App\Builder\UtilityVehicleBuilder as UtilityVehicleBuilder;
use phpDocumentor\Reflection\Types\This;
use function Symfony\Component\Translation\t;

class Director
{
    private $carBuilder;
    private $utilityVehicleBuilder;

    public function __construct(CarBuilder $carBuilder, UtilityVehicleBuilder $utilityVehicleBuilder)
    {
        $this->carBuilder = $carBuilder;
        $this->utilityVehicleBuilder = $utilityVehicleBuilder;
    }

    public function buildVehicle($type)
    {
        switch ($type)
        {
            case ("Car"):
                return $this->carBuilder;
            case ("UtilityVehicle"):
                return $this->utilityVehicleBuilder;
        }
    }
}