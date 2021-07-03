<?php

namespace App\Repository;

use App\Entity\Anonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Anonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anonce[]    findAll()
 * @method Anonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anonce::class);
    }

    public function findBestAds($limit){
        return $this->createQueryBuilder('a')
        ->select('a as annonce, AVG(c.rating) as avgRatings')
        ->join('a.comments','c')
        ->groupBy('a')
        ->orderBy('avgRatings','DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
    }
    // /**
    //  * @return Anonce[] Returns an array of Anonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Anonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
