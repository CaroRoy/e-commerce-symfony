<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // Pour afficher des produits recommandés sur la page show_product d'un produit sélectionné
    /**
     * @return Product[] Returns an array of Products
     */
    public function findProductToPropose(Product $product)
    {
        return $this->createQueryBuilder('p')
            // on ne veut pas l'id qui correspond au produit sélectionné (on veut tous sauf celui-ci)
            ->andWhere('p.id != :id_product')
            // cet id qu'on ne veut pas, c'est le $product->getId()
            ->setParameter('id_product', $product->getId())
            // on veut les produits qui appartiennent à la même catégorie du produit sélectionné
            ->andWhere('p.category = :category')
            ->setParameter('category', $product->getCategory())
            // on ne veut que 4 résultats max
            ->setMaxResults(4)
            // on envoie la requête
            ->getQuery()
            // on récupère les résultats
            ->getResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
