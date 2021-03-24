<?php

namespace App\Services;

use Exception;

/**
 * Ce service permet de récupérer les données du formulaire et de structurer le tableau au format attendu
 * Class SetResultFrontIntoArray
 * @package App\Services
 */
class SetResultFrontIntoArray
{
    /**
     * @param $data
     * @return array
     * @throws Exception
     */
    public function setResultIntoArray($data): array
    {
        //Récupération des données
        $type = $data['resultType'];
        $label = $data['resultLabel'];
        $brand = $data['resultBrand'];
        $conceptionDate = new \DateTime($data['resultConceptionDate']);
        $lastControl = new \DateTime($data['resultLastControl']);
        $fuel = $data['resultFuel'];
        $licence = $data['resultLicence'];
        $description = $data['resultDescription'];

        //Création du tableau de données
        $dataArray = [
            "type" => $type,
            "label" => $label,
            "brand" => $brand,
            "conceptionDate" => $conceptionDate,
            "lastControl" => $lastControl,
            "fuel" => $fuel,
            "licence" => $licence,
            "description" => $description
        ];

        //Ajoute au tableau les données nécessaires
        switch ($type) {
            case "UtilityVehicle":
                $maxLoad = $data['resultMaxLoad'];
                $trunkCapacity = $data['resultTrunkCapacity'];
                //Ajoute les données dans le tableau
                $dataArray["resultMaxLoad"] = $maxLoad;
                $dataArray["resultTrunkCapacity"] = $trunkCapacity;
                break;
            case "Motorcycle":
                $helmetAvailable = $data['resultHelmetAvailable'];
                //Ajoute les données dans le tableau
                $dataArray["resultHelmetAvailable"] = $helmetAvailable;
                break;
        }
        return $dataArray;
    }
}