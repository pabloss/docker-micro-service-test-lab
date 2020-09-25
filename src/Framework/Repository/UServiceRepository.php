<?php

namespace App\Framework\Repository;

use App\AppCore\Domain\Actors\uServiceInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\Framework\Entity\UService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UService|null find($id, $lockMode = null, $lockVersion = null)
 * @method UService|null findOneBy(array $criteria, array $orderBy = null)
 * @method UService[]    findAll()
 * @method UService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UServiceRepository extends ServiceEntityRepository implements uServiceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UService::class);
    }

    public function persist(uServiceInterface $domain)
    {
        $domain->setUuid($this->getUuidFromDir(\dirname($domain->getFile())));
        $this->getEntityManager()->persist($domain);
        $this->getEntityManager()->flush();
    }

    public function all()
    {
        return $this->findAll();
    }

    public function findByHash(string $hash)
    {
        return $this->findOneBy(['uuid' =>$hash]);
    }

    /**
     * @param string $dirPath
     *
     * @return string
     */
    private function getUuidFromDir(string $dirPath): string
    {
        \preg_match('/(\w+)$/', $dirPath, $matches);
        if (\count($matches) < 2) {
            $matches = ['/'];
        }

        return $matches[0];
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
