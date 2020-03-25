<?php

namespace App\Framework\Repository;

use App\Framework\Entity\UService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UService|null find($id, $lockMode = null, $lockVersion = null)
 * @method UService|null findOneBy(array $criteria, array $orderBy = null)
 * @method UService[]    findAll()
 * @method UService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UService::class);
    }

    // /**
    //  * @return UService[] Returns an array of UService objects
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
    public function findOneBySomeField($value): ?UService
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
