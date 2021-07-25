<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Category;

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


    /**
   *  this request will pick up the products depends of the users request
   * @return Product[]
   */ 
    
    public function findWithSearch(Search $search)
    
    {
        $query = $this
        ->createQueryBuilder('p')
        // what do you want for the section : product and category
        ->select('c', 'p')
        // i want a join between categories of my product 
        ->join('p.category','c' );

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);

        }

        if (!empty($search->string)) {
            $query = $query

            ->andWhere('p.name LIKE :string')
            ->setParameter('string', "%($search->string)%");

             
        }

        // I want a return of my query

        return $query->getQuery()->getResult();
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
