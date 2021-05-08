<?php

namespace App\Repository;

use App\Entity\FavouriteStation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FavouriteStation|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavouriteStation|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavouriteStation[]    findAll()
 * @method FavouriteStation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavouriteStationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavouriteStation::class);
    }

    // /**
    //  * @return FavouriteStation[] Returns an array of FavouriteStation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FavouriteStation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
