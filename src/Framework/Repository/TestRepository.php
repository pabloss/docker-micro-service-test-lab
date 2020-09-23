<?php

namespace App\Framework\Repository;

use App\AppCore\Domain\Repository\TestEntityInterface;
use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\Framework\Entity\Test;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Test|null find($id, $lockMode = null, $lockVersion = null)
 * @method Test|null findOneBy(array $criteria, array $orderBy = null)
 * @method Test[]    findAll()
 * @method Test[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestRepository extends ServiceEntityRepository implements TestRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Test::class);
    }

    public function persist(TestEntityInterface $domain, ?string $nextId)
    {
        $this->getEntityManager()->persist($domain);
//        $this->getEntityManager()->persist($domain->getUService());
        $this->getEntityManager()->flush();
    }

    public function all()
    {
        return $this->findAll();
    }

    public function findByHash(string $uuid)
    {
        return $this->findOneBy(['uuid' => $uuid]);
    }

    // /**
    //  * @return Test[] Returns an array of Test objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Test
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
