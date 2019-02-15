<?php

namespace App\Repository;

use App\Entity\Librarian;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Librarian|null find($id, $lockMode = null, $lockVersion = null)
 * @method Librarian|null findOneBy(array $criteria, array $orderBy = null)
 * @method Librarian[]    findAll()
 * @method Librarian[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LibrarianRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Librarian::class);
    }

    public function getLibrarianWithLibrary(Library $library)
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


    // /**
    //  * @return Librarian[] Returns an array of Librarian objects
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
    public function findOneBySomeField($value): ?Librarian
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
