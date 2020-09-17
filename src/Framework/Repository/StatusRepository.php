<?php

namespace App\Framework\Repository;

use App\AppCore\Domain\Repository\StatusEntity;
use App\AppCore\Domain\Service\StatusRepositoryInterface;
use App\Framework\Entity\Status;
use App\Framework\Entity\UService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Status|null find($id, $lockMode = null, $lockVersion = null)
 * @method Status|null findOneBy(array $criteria, array $orderBy = null)
 * @method Status[]    findAll()
 * @method Status[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusRepository extends ServiceEntityRepository implements StatusRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Status::class);
    }

    public function save(StatusEntity $entity)
    {
        $statusEntity = new Status();
        $statusEntity->setStatusName($entity->statusString());
        $statusEntity->setUuid($entity->uuid());
        $statusEntity->setCreated($entity->when());
        $statusEntity->setUService($this->getEntityManager()->getRepository(UService::class)->findOneBy(['uuid' => $entity->uuid()]));
        $this->getEntityManager()->persist($statusEntity);
    }


    // /**
    //  * @return Status[] Returns an array of Status objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Status
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
