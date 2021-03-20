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
                $dataArray["maxLoad"] = $maxLoad;
                $dataArray["trunkCapacity"] = $trunkCapacity;
                break;
            case "Motorcycle":
                $helmetAvailable = $data['resultHelmetAvailable'];
                //Ajoute les données dans le tableau
                $dataArray["helmetAvailable"] = $helmetAvailable;
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
        $dataReceive = json_decode($this->request->getCurrentRequest()->getContent(), true);
        $data = $this->setResultIntoArray($dataReceive);
        // Création d'un nouveau véhicule
        $vehicleBuilder = new VehicleBuilder();
        $vehicleBuilder->setAndCheckVehicleType($data, $this->entityManager);

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
        // TODO : On envoie au front toutes les informations du véhhicule à éditer. Dans le formulaire d'édition on renverra tous les champs, même ceux que l'utilisateur n'a pas changé.
        $vehicleToEdit = $this->vehicleRepository->find($idToEdit);

        $dataReceive = json_decode($this->request->getCurrentRequest()->getContent(), true);
        $data = $this->setResultIntoArray($dataReceive);

        $vehicleToEdit
            ->setLabel($data['label'])
            ->setBrand($data["brand"])
            ->setConceptionDate($data["conceptionDate"])
            ->setLastControl($data["lastControl"])
            ->setFuel($data["fuel"])
            ->setLicence($data["licence"]);
        
        // Enregistre le véhicule standard.
        $this->entityManager->persist($vehicleToEdit);
        
        // Mise a jour de la table moto si elle existe
        $moto = $vehicleToEdit->getMotorcycle();
        $utilityVehicle = $vehicleToEdit->getUtilityVehicle();
        if ($moto) {
            $moto
                ->setVehicle($vehicleToEdit)
                ->setHelmetAvailable($data['helmetAvailable']);
            $this->entityManager->persist($moto);
        }
        // Idem pour un véhicule utilitaire :)
        if ($utilityVehicle) {
            $utilityVehicle
                ->setVehicle($vehicleToEdit)
                ->setMaxLoad($data['maxLoad'])
                ->setTrunkCapacity($data['trunkCapacity']);
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
        // Voir avec Fabien ce qu'il veut exactement comme retour, + renvoyer toutes les données du véhicule.
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
