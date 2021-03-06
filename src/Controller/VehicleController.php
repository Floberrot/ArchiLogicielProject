<?php

namespace App\Controller;

use App\Builder\MotorcycleBuilder;
use App\Builder\UtilityVehicleBuilder;
use App\Builder\VehicleBuilder;
use App\Services\SetResultFrontIntoArray;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\VehicleDetailsBuilder;
use App\Builder\VehicleEditBuilder;
use App\Entity\Vehicle;
use Exception;
use App\Repository\MotorcycleRepository;
use App\Repository\UtilityVehicleRepository;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class VehicleController extends AbstractController
{

    private $entityManager;
    private $vehicleRepository;
    private $motorcycleRepository;
    private $utilityVehicleRepository;
    protected $request;
    private $setResultFrontIntoArray;
    private $motorcycle;
    private $utilityVehicle;

    public function __construct(
        EntityManagerInterface $entityManager,
        VehicleRepository $vehicleRepository,
        MotorcycleRepository $motorcycleRepository,
        UtilityVehicleRepository $utilityVehicleRepository,
        RequestStack $request,
        SetResultFrontIntoArray $setResultFrontIntoArray,
        MotorcycleBuilder $motorcycle,
        UtilityVehicleBuilder $utilityVehicle)
    {
        $this->entityManager = $entityManager;
        $this->vehicleRepository = $vehicleRepository;
        $this->motorcycleRepository = $motorcycleRepository;
        $this->utilityVehicleRepository = $utilityVehicleRepository;
        $this->request = $request;
        $this->setResultFrontIntoArray = $setResultFrontIntoArray;
        $this->motorcycle = $motorcycle;
        $this->utilityVehicle = $utilityVehicle;
    }

    /**
     * Créer un nouveau Vehicule
     * @Route ("/api/vehicle", name="create_vehicle", methods={"POST"})
     * @return JsonResponse
     * @throws Exception
     */
  public function createVehicle() : JsonResponse
  {
         $dataReceive = json_decode($this->request->getCurrentRequest()->getContent(), true);
         $data = $this->setResultFrontIntoArray->setResultIntoArray($dataReceive);
        // Création d'un nouveau véhicule
        $vehicleBuilder = new VehicleBuilder($this->motorcycle,$this->utilityVehicle);
        $vehicleBuilder->createStandardVehicle($data, $this->entityManager);
        $this->entityManager->flush();
        return new JsonResponse(
            [
                'message' => 'Le véhicule a bien été enregistré !'
            ], 200, [], false);
    }


    /**
     * @param mixed $idToEdit
     * @Route("/api/vehicle/{idToEdit}", name="edit_vehicle", methods={"PUT"})
     * @return JsonResponse
     * @throws Exception
     */
    public function editVehicle($idToEdit) : JsonResponse
    {
        $vehicleToEdit = $this->vehicleRepository->find($idToEdit);
        $dataReceive = json_decode($this->request->getCurrentRequest()->getContent(), true);
        $data = $this->setResultFrontIntoArray->setResultIntoArray($dataReceive);
        $vehicleToEdit
            ->setLabel($data['label'])
            ->setBrand($data["brand"])
            // ->setConceptionDate($data["conceptionDate"])
            ->setLastControl($data["lastControl"])
            ->setFuel($data["fuel"])
            ->setLicence($data["licence"])
            ->setDescription($data["description"]);
        
        // Enregistre le véhicule standard.
        $this->entityManager->persist($vehicleToEdit);
        $motorcycleBuilder = new MotorcycleBuilder($this->entityManager);
        $utilityVehiculeBuilder = new UtilityVehicleBuilder($this->entityManager);
        $motorcycleBuilder->editMotorcycle($vehicleToEdit, $data);
        $utilityVehiculeBuilder->editUtilityVehicle($vehicleToEdit, $data);
        // Save en bdd
        $this->entityManager->flush();
        return new JsonResponse([
            'message' => 'Vos modifications ont bien été mises a jours.'
        ], 200, [], false);
    }

    /**
     * Cette fonction affiche tous les véhicules de la DB
     * @Route("/api/vehicle", name="showVehicles", methods={"GET"})
     * @return JsonResponse
     */
    public function showVehicles() : JsonResponse
    {
        $allVehicle = new Vehicle();
        $allVehicle = $this->vehicleRepository->findAll();
        $vehiclesToDisplay = [];
        foreach ($allVehicle as $oneVehicle)
        {
            $id = $oneVehicle->getId();
            $label = $oneVehicle->getLabel();
            $brand = $oneVehicle->getBrand();
            $licence = $oneVehicle->getLicence();
            $isPublic = $oneVehicle->getIsPublic();
            $dataOfVehicles['id'] = $id;
            $dataOfVehicles['label'] = $label;
            $dataOfVehicles['brand'] = $brand;
            $dataOfVehicles['licence'] = $licence;
            $dataOfVehicles['isPublic'] = $isPublic;
            if ($oneVehicle->getMotorcycle()) {
                $dataOfVehicles['type'] = 'Moto';
            } else if ($oneVehicle->getUtilityVehicle()) {
                $dataOfVehicles['type'] = 'Véhicule utilitaire';
            } else {
                $dataOfVehicles['type'] = 'Standard';
            }
            array_push($vehiclesToDisplay, $dataOfVehicles);
        }
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
        // Cherche un véhicule grâce à son id.
        $vehicleEntity = $this->vehicleRepository->find($idDetails);
        $detailOneVehicle = [];
        // Appel la class pour afficher les détails d'un véhicule.
        $vehicleDetailClass = new VehicleBuilder($this->motorcycle, $this->utilityVehicle);
        $vehicleDetailClass->detailsBuilder($vehicleEntity, $detailOneVehicle, $idDetails, $this->entityManager, $this->motorcycleRepository, $this->utilityVehicleRepository);
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
     * @param $idToDelete
     * @return JsonResponse
     */
    public function deleteVehicle($idToDelete) :JsonResponse
    {
        // On vérifie que la méthode est bien "DELETE"
         if ($this->request->getCurrentRequest()->getMethod() === "DELETE") {
            // On fait une requête pour trouver l'entité associé à l'id.
            $vehicleToDelete = $this->vehicleRepository->find($idToDelete);
            if(!$vehicleToDelete) {
                return new JsonResponse('Erreur lors de la suppression, ce véhicule n\'exite pas', 500, [], true);
            }
            $this->entityManager->remove($vehicleToDelete);
            $this->entityManager->flush();
            return new JsonResponse(
                [
                'message' => 'Vehicule supprimé !'
                ], 200, [], false);
        } else {
            return new JsonResponse(
                [
                    'message' => 'La methode de requête est mauvaise',
                ], 500, [], false);
        }
    }

    /**
     * @Route("/change/privacy/{idToEdit}", name="privacy_vehicle", methods={"POST"})
     * @param $idToEdit
     * @return JsonResponse
     **/
    public function changeStatusOfVehiclePrivacy($idToEdit): JsonResponse
    {
        $request = $this->request->getCurrentRequest();
        if ($request->getMethod() === "POST") {
            // On récupère la valeur que nous renvoie le front.
            $dataInRequest = $request->getContent();
            $response = json_decode($dataInRequest, true);
            $valueStatusPrivacy = $response['valueStatusPrivacy'];
            // On cherche le véhicule avec l'id que l'on reçoit du front.
            $vehicleToChangeStatus = $this->vehicleRepository->find($idToEdit);
            // Si le front nous renvoie "true", on passe le statut a publique, si c'est faux, on le passe en privé
            switch ($valueStatusPrivacy) {
                case true:
                    $vehicleToChangeStatus->setIsPublic(true);
                    $this->entityManager->persist($vehicleToChangeStatus);
                    $this->entityManager->flush();
                    return new JsonResponse(
                        [
                            'message' => 'Le véhicule est en statut : publique.'
                        ], 200, [], false);
                case false:
                    $vehicleToChangeStatus->setIsPublic(false);
                    $this->entityManager->persist($vehicleToChangeStatus);
                    $this->entityManager->flush();
                    return new JsonResponse(
                        [
                            'message' => 'Le véhicule est en statut : privé.'
                        ], 200, [], false);
            }
        } else {
            return new JsonResponse(
                [
                    'message' => 'Mauvaise méthode de requete, méthode attendu : POST'
                ], 404, [], true);
        }
    }
}
