<?php

namespace App\Repository;

use App\Entity\PasswordUpadte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PasswordUpadte|null find($id, $lockMode = null, $lockVersion = null)
 * @method PasswordUpadte|null findOneBy(array $criteria, array $orderBy = null)
 * @method PasswordUpadte[]    findAll()
 * @method PasswordUpadte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PasswordUpadteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PasswordUpadte::class);
    }

    // /**
    //  * @return PasswordUpadte[] Returns an array of PasswordUpadte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PasswordUpadte
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
