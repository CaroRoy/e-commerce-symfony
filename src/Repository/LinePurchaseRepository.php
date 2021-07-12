<?php

namespace App\Repository;

use App\Entity\LinePurchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LinePurchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinePurchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinePurchase[]    findAll()
 * @method LinePurchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinePurchaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinePurchase::class);
    }

    // /**
    //  * @return LinePurchase[] Returns an array of LinePurchase objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LinePurchase
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
