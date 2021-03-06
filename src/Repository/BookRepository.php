<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    // public function getBookWithCategory(){
    //   return $this->createQueryBuilder('b')
    //       ->addSelect('c')
    //       ->leftJoin('b.category' ,'c')
    //       ->getQuery()
    //       ->getResult()
    //   ;
    // }

    public function getOneBookWithCategory($id)
    {
        return $this->createQueryBuilder('b')
            // p.category refers to the "category" property on product
            ->leftJoin('b.category' ,'c')
            // selects all the category data to avoid the query
            ->addSelect('c')
            ->andWhere('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }


    public function getBookWithCategory(Category $category)
    {
        return $this->createQueryBuilder('b')
            ->addSelect('c')
            ->leftJoin('b.category' ,'c')
            ->addSelect('u')
            ->leftJoin('b.user', 'u')
            ->andWhere('c.id = :val')
            ->setParameter('val', $category)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBookAndUser(int $id): ?Book
{
  return $this->createQueryBuilder('b')
    ->addSelect('u')
    ->leftJoin('b.user', 'u')
    ->addSelect('c')
    ->leftJoin('b.category', 'c')
    ->andWhere('b.id = :id')
    ->setParameter('id', $id)
    ->getQuery()
    ->getOneOrNullResult();
}

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
