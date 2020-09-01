<?php
declare(strict_types=1);

namespace App\Framework\Persistence;

use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\PersistGatewayInterface;
use App\AppCore\Domain\Repository\TestEntity;
use App\Framework\Entity\Test;
use Doctrine\ORM\EntityManagerInterface;

class TestPersistGatewayAdapter implements PersistGatewayInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function nextId()
    {
        $all = $this->entityManager->getRepository(Test::class)->findAll();
        return empty($all) ? 0 : \end($all)->getId()+1;
    }

    public function getAll()
    {
        return $this->entityManager->getRepository(Test::class)->findAll();
    }

    public function persist(EntityInterface $testEntity)
    {
        if(null === $testEntity->id()){
            $frameworkTestEntity = Test::fromDomainEntity($testEntity, null);
        } else{
            $frameworkTestEntity = $this->entityManager->getRepository(Test::class)->find($testEntity->id());
            $frameworkTestEntity->setUuid($testEntity->uuid());
            $frameworkTestEntity->setBody($testEntity->body());
            $frameworkTestEntity->setScript($testEntity->script());
            $frameworkTestEntity->setHeader($testEntity->header());
            $frameworkTestEntity->setUrl($testEntity->url());
            $frameworkTestEntity->setRequestedBody($testEntity->requestedBody());
        }
        $this->entityManager->persist($frameworkTestEntity);
        $this->entityManager->flush();
    }

    public function find(string $id)
    {
        /** @var Test $frameworkEntity */
        $frameworkEntity = $this->entityManager->getRepository(Test::class)->find($id);
        return $uServiceEntity = new TestEntity($frameworkEntity->getUuid(), $frameworkEntity->getRequestedBody(), $frameworkEntity->getId());
    }

    public function findByHash(string $hash)
    {
        $frameworkEntity = $this->entityManager->getRepository(Test::class)
            ->createQueryBuilder('t')
            ->where('t.uuid LIKE :uuid')
            ->setParameter('uuid', $hash)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
        return new TestEntity($frameworkEntity->getUuid(), $frameworkEntity->getRequestedBody(), $frameworkEntity->getId());
    }
}
