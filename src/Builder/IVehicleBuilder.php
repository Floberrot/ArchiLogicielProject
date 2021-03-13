<?php

namespace App\Builder;


use Monolog\Handler\SamplingHandler;

interface IVehicleBuilder
{
    public function setLabel();
    // public function setBrand();
    // public function setConceptionDate();
    // public function setLastControl();
    // public function setFuel();
    // public function setLicence();
    // public function setLicenceType();
    public function getCar();
}