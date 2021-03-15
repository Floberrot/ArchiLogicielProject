<?php

namespace App\Builder;


use Monolog\Handler\SamplingHandler;
use Symfony\Component\Validator\Constraints\DateTime;

interface IVehicleBuilder
{
    public function setLabelBuilder(String $label);
     public function setBrandBuilder(String $brand);
     public function setConceptionDateBuilder(\DateTimeInterface $conceptionDate);
     public function setLastControlBuilder(\DateTimeInterface $lastControl);
     public function setFuelBuilder(String $fuel);
     public function setLicenceBuilder(String $licence);
    public function getCar();
}