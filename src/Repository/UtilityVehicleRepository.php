<?php

namespace App\Repository;

use App\Entity\UtilityVehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UtilityVehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method UtilityVehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method UtilityVehicle[]    findAll()
 * @method UtilityVehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilityVehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UtilityVehicle::class);
    }

    // /**
    //  * @return UtilityVehicle[] Returns an array of UtilityVehicle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UtilityVehicle
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
