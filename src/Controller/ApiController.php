<?php

namespace App\Controller;

use App\Builder\VehicleBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\VehicleDetailsBuilder;
use App\Entity\Vehicle;
use App\Repository\MotorcycleRepository;
use App\Repository\UtilityVehicleRepository;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ApiController extends AbstractController
{

    private $entityManager;
    private $vehicleRepository;
    private $motorcycleRepository;
    private $utilityVehicleRepository;
    protected $request;

    public function __construct(
        EntityManagerInterface $entityManager,
        VehicleRepository $vehicleRepository,
        MotorcycleRepository $motorcycleRepository,
        UtilityVehicleRepository $utilityVehicleRepository,
        RequestStack $request)
    {
        $this->entityManager = $entityManager;
        $this->vehicleRepository = $vehicleRepository;
        $this->motorcycleRepository = $motorcycleRepository;
        $this->utilityVehicleRepository = $utilityVehicleRepository;
        $this->request = $request;
    }
    /**
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function getData(Request $request): array
    {
        //Récupération des données
        $data = $request->getContent();
        $type = $data['resultType'];
        $label = $data['resultLabel'];
        $brand = $data['resultBrand'];
        $conceptionDate = new \DateTime($data['resultConceptionDate']);
        $lastControl = new \DateTime($data['resultLastControl']);
        $fuel = $data['resultFuel'];
        $licence = $data['resultLicence'];

        //Création du tableau de données
        $dataArray = [
            "type" => $type,
            "label" => $label,
            "brand" => $brand,
            "conceptionDate" => $conceptionDate,
            "lastControl" => $lastControl,
            "fuel" => $fuel,
            "licence" => $licence
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

    /**
     * Créer un nouveau Vehicule
     * @Route ("/api/vehicle", name="create_vehicle", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
  public function createVehicle() : JsonResponse
  {
        // Résultats de la requête (Json decode à faire)
        // Champ type en bdd ?
        $res = [
            "type" => "UtilityVehicle",
            "ResultLabel" => "Label",
            "ResultBrand" => "Merco",
            "ResultConceptionDate" => new \DateTime(),
            "ResultLastControl" => new \DateTime(),
            "ResultFuel" => "Diesel",
            "ResultLicence" => "Permis b",
            "resultMaxLoad" => "10.5",
            "resultTrunkCapacity" => "10.5",
        ];
        // Création d'un nouveau véhicule
        $vehicleBuilder = new VehicleBuilder();
        $vehicleBuilder->setAndCheckVehicleType($res, $this->entityManager);

        $this->entityManager->flush();

        return new JsonResponse('ok', 200, [], true);
    }


    /**
     * @param mixed $idToEdit
     * @Route("/api/vehicle/{idToEdit}", name="edit_vehicle", methods={"PUT"})
     * @return JsonResponse
     */
    public function editVehicle($idToEdit) : JsonResponse
    {
        // TODO : refacto la fonction !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $vehicleToEdit = $this->vehicleRepository->find($idToEdit);

        // Nous recevrons ici les résultats du Front.
        $resEdit = [
            "type" => "UtilityVehicle",
            "ResultLabel" => "Test update 45",
            "ResultBrand" => "ptite lambo",
            "ResultConceptionDate" => new \DateTime(),
            "ResultLastControl" => new \DateTime(),
            "ResultFuel" => "sp95",
            "ResultLicence" => "Permis ouais",
            "resultMaxLoad" => "1000",
            "resultTrunkCapacity" => "2000.1",
        ];

        $vehicleToEdit
            ->setLabel($resEdit['ResultLabel'])
            ->setBrand($resEdit["ResultBrand"])
            ->setConceptionDate($resEdit["ResultConceptionDate"])
            ->setLastControl($resEdit["ResultLastControl"])
            ->setFuel($resEdit["ResultFuel"])
            ->setLicence($resEdit["ResultLicence"]);
        
        // Enregistre le véhicule standard.
        $this->entityManager->persist($vehicleToEdit);
        
        // Mise a jour de la table moto si elle existe
        $moto = $vehicleToEdit->getMotorcycle();
        $utilityVehicle = $vehicleToEdit->getUtilityVehicle();
        if ($moto) {
            $moto
                ->setVehicle($vehicleToEdit)
                ->setHelmetAvailable($resEdit['helmetAvailable']);
            $this->entityManager->persist($moto);
        }
        // Idem pour un véhicule utilitaire :)
        if ($utilityVehicle) {
            $utilityVehicle
                ->setVehicle($vehicleToEdit)
                ->setMaxLoad($resEdit['resultMaxLoad'])
                ->setTrunkCapacity($resEdit['resultTrunkCapacity']);
            $this->entityManager->persist($utilityVehicle);
        }
        // Save en bdd
        $this->entityManager->flush();

        return new JsonResponse('edit ok', 200, [], true);
    }
    
    /**
     * Cette fonction affiche tous les véhicules de la DB
     * @Route("/api/vehicle", name="showVehicles", methods={"GET"})
     * @param VehicleRepository $vehicleRepository
     * @return JsonResponse
     */
    public function showVehicles() : JsonResponse
    {
        $allVehicle = new Vehicle();
        $allVehicle = $this->vehicleRepository->findAll();
        $vehiclesToDisplay = [];
        foreach ($allVehicle as $oneVehicle)
        {
            $label = $oneVehicle->getLabel();
            $brand = $oneVehicle->getBrand();
            $licence = $oneVehicle->getLicence();
            $dataOfVehicles['label'] = $label;
            $dataOfVehicles['brand'] = $brand;
            $dataOfVehicles['licence'] = $licence;
            array_push($vehiclesToDisplay, $dataOfVehicles);
        }
        // Voir avec Fabien ce qu'il veut comme valeur de retour.
        return new JsonResponse(
            [
                'arrayOfVehicles' => $vehiclesToDisplay
            ]
        );
    }

    /**
     * Cette fonction affiche les détails d'un seul véhicule.
     * Vérification du type si il en a un evidemment.
     * @Route("/api/vehicle/{idDetails}", name="detail_vehicle", methods={"GET"})
     * @param $idDetails
     * @return JsonResponse
     */
    public function detailVehicle($idDetails) : JsonResponse
    {
        $vehicleEntity = new Vehicle(); 
        // Cherche un véhicule grâce à son id.
        $vehicleEntity = $this->vehicleRepository->find($idDetails);
        $detailOneVehicle = [];
        // Appel la class pour afficher les détails d'un véhicule.
        $vehicleDetailClass = new VehicleDetailsBuilder($this->motorcycleRepository, $this->utilityVehicleRepository);
        $vehicleDetailClass->detailsBuilder($vehicleEntity, $detailOneVehicle, $idDetails);
        // Voir avec Fabien ce qu'il veut exactement comme retour
        return new JsonResponse(
            [
                'detailVehicle' => $detailOneVehicle
            ]
        );
    }

    /**
     * Supprime un véhicule de la DB.
     * Dans le cas ou il y a un véhicule particulier (véhicule utilitaire, moto etc...), il se supprime en cascade.
     * @Route ("/api/vehicle/{idToDelete}", name="delete_vehicle", methods={"DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function deleteVehicle($idToDelete) :JsonResponse
    {
        // On vérifie que la méthode est bien "DELETE"
         if ($this->request->getCurrentRequest()->getMethod() === "DELETE") {
            $vehicleToDelete = new Vehicle();
            // On fait une requête pour trouver l'entité associé à l'id.
            $vehicleToDelete = $this->vehicleRepository->find($idToDelete);
            if(!$vehicleToDelete) {
                return new JsonResponse('Erreur lors de la suppression, ce véhicule n\'exite pas', 500, [], true);
            }
            $this->entityManager->remove($vehicleToDelete);
            $this->entityManager->flush();
            
            //$this->entityManager->remove($vehicleToDelete);
            return new JsonResponse('Vehicule supprimé', 200, [], true);
        } else {
            return new JsonResponse('La methode de requête est mauvaise', 500, [], true);
        }
    }
}
