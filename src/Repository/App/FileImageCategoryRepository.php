<?php

namespace App\Repository\App;

use App\Entity\App\FileImageCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FileImageCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileImageCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileImageCategory[]    findAll()
 * @method FileImageCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileImageCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FileImageCategory::class);
    }

    // /**
    //  * @return FileImageCategory[] Returns an array of FileImageCategory objects
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
    public function findOneBySomeField($value): ?FileImageCategory
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
