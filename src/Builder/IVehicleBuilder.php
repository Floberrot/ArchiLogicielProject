<?php

namespace App\Builder;


use Monolog\Handler\SamplingHandler;

interface IVehicleBuilder
{
    public function setLabel($label);
    public function setBrand($brand);
    public function setConceptionDate($conceptionDate);
    public function setLastControl($lastControl);
    public function setFuel($fuel);
    public function setLicence($licence);
    public function setLicenceType($licenceType);
}