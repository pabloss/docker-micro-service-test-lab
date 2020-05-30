<?php

namespace App\Repository\App\Framework\Entity;

use App\Entity\App\Framework\Entity\Connectin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Connectin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Connectin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Connectin[]    findAll()
 * @method Connectin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnectinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Connectin::class);
    }

    // /**
    //  * @return Connectin[] Returns an array of Connectin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Connectin
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
