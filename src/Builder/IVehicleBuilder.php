<?php

namespace App\Builder;

use Symfony\Component\Validator\Constraints\Date;

interface IVehicleBuilder
{
    public function setLabel() : string;

    public function setBrand() : string;

    public function setConceptionDate() : int;

    public function setLastControl() : Date;

    public function setFuel() : string;

    public function setLicence() : bool;

    public function setLicenceType() : string;
}