<?php

namespace App\Controller;

use App\Builder\VehicleBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\VehicleDetailsBuilder;
use App\Builder\VehicleEditBuilder;
use App\Entity\Vehicle;
use App\Repository\MotorcycleRepository;
use App\Repository\UtilityVehicleRepository;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{

    private $entityManager;
    private $vehicleRepository;
    private $motorcycleRepository;
    private $utilityVehicleRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        VehicleRepository $vehicleRepository,
        MotorcycleRepository $motorcycleRepository,
        UtilityVehicleRepository $utilityVehicleRepository)
    {
        $this->entityManager = $entityManager;
        $this->vehicleRepository = $vehicleRepository;
        $this->motorcycleRepository = $motorcycleRepository;
        $this->utilityVehicleRepository = $utilityVehicleRepository;
    }
    /**
     * Créer un nouveau Vehicule
     * @Route ("/api/vehicle", name="create_vehicle", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
  public function createVehicle(Request $request) : JsonResponse
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
    public function editVehicle($idToEdit, VehicleRepository $vehicleRepository, EntityManagerInterface $entityManager) : JsonResponse
    {
<<<<<<< Updated upstream
        $vehicleToEdit = $vehicleRepository->find($idToEdit);
=======
        // TODO : On envoie au front toutes les informations du véhhicule à éditer. Dans le formulaire d'édition on renverra tous les champs, même ceux que l'utilisateur n'a pas changé.
        $vehicleToEdit = $this->vehicleRepository->find($idToEdit);
>>>>>>> Stashed changes

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
<<<<<<< Updated upstream
        $entityManager->persist($vehicleToEdit);
        
        // Mise a jour de la table moto si elle existe
        $moto = $vehicleToEdit->getMotorcycle();
        $utilityVehicle = $vehicleToEdit->getUtilityVehicle();
        if ($moto) {
            $moto
                ->setVehicle($vehicleToEdit)
                ->setHelmetAvailable($resEdit['helmetAvailable']);
            $entityManager->persist($moto);
        }
        // Idem pour un véhicule utilitaire :)
        if ($utilityVehicle) {
            $utilityVehicle
                ->setVehicle($vehicleToEdit)
                ->setMaxLoad($resEdit['resultMaxLoad'])
                ->setTrunkCapacity($resEdit['resultTrunkCapacity']);
            $entityManager->persist($utilityVehicle);
        }
=======
        $this->entityManager->persist($vehicleToEdit);
        $vehicleEditBuilder = new VehicleEditBuilder($vehicleToEdit);
        $vehicleEditBuilder->editMotorcycle($vehicleToEdit, $data);
        $vehicleEditBuilder->editUtilityVehicle($vehicleToEdit, $data);
        
>>>>>>> Stashed changes
        // Save en bdd
        $entityManager->flush();

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
        $vehicleToDisplay = [];
        foreach ($allVehicle as $oneVehicle)
        {
            $label = $oneVehicle->getLabel();
            $brand = $oneVehicle->getBrand();
            $licence = $oneVehicle->getLicence();
            $dataOfVehicles['label'] = $label;
            $dataOfVehicles['brand'] = $brand;
            $dataOfVehicles['licence'] = $licence;
            array_push($vehicleToDisplay, $dataOfVehicles);
        }
        // Voir avec Fabien ce qu'il veut comme valeur de retour.
        return new JsonResponse(
            [
                'arrayOfVehicles' => $vehicleToDisplay
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
    public function deleteVehicle($idToDelete, VehicleRepository $vehicleRepository) :JsonResponse
    {
        // On vérifie que la méthode est bien "DELETE"
         if ($this->request->getCurrentRequest()->getMethod() === "DELETE") {
            $vehicleToDelete = new Vehicle();
            // On fait une requête pour trouver l'entité associé à l'id.
            $vehicleToDelete = $vehicleRepository->find($idToDelete);
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
