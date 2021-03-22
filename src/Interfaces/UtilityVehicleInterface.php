<?php

namespace App\Interfaces;
use App\Entity\Vehicle;

/**
 * Class UtilityVehicleInterface
 * @package App\Interfaces
 */
class UtilityVehicleInterface extends Vehicle
{
    private $max_load;
    private $trunk_capacity;
}