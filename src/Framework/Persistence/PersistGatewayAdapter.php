<?php
declare(strict_types=1);

namespace App\Framework\Persistence;

use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\PersistGatewayInterface;
use App\AppCore\Domain\Repository\TestEntity;
use App\AppCore\Domain\Repository\uServiceEntity;
use App\Framework\Entity\UService;
use App\Framework\Factory\EntityFactory;
use Doctrine\ORM\EntityManagerInterface;

class PersistGatewayAdapter implements PersistGatewayInterface
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
        $all = $this->entityManager->getRepository(UService::class)->findAll();
        return empty($all) ? 0 : \end($all)->getId()+1;
    }

    public function getAll()
    {
        return \array_map(function (UService $entity){
           return $this->mapFrameworkEntity($entity);
        }, $this->entityManager->getRepository(UService::class)->findAll());
    }

    public function persist(EntityInterface $uServiceEntity)
    {
        $factory = new EntityFactory();
        $this->entityManager->persist($factory->createService($uServiceEntity->getFile(), $uServiceEntity->getMovedToDir()));
        $this->entityManager->flush();
    }

    public function find(string $id)
    {
        return $this->entityManager->getRepository(UService::class)->find($id);
    }

    public function findByHash(string $hash)
    {
        $entity = $this->entityManager->getRepository(UService::class)
            ->createQueryBuilder('us')
            ->where('us.file LIKE :file')
            ->setParameter('file', '%' . $hash . '%')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
        return $this->mapFrameworkEntity($entity);
    }

    /**
     * @param $entity
     *
     * @return uServiceEntity
     */
    private function mapFrameworkEntity($entity): uServiceEntity
    {
        $uServiceEntity = new uServiceEntity($entity->getMovedToDir(), $entity->getFile(), $entity->getFile(),
            (string)$entity->getId());
        if (null !== ($test = $entity->getTests()->first())) {
            $uServiceEntity->setTest(
                new TestEntity($entity->getUuid(), $test->getRequestedBody(), $test->getBody(), $test->getHeader(),
                    $test->getScript(), $test->getUrl(), (string)$test->getId())
            );
        }
        return $uServiceEntity;
}
}
