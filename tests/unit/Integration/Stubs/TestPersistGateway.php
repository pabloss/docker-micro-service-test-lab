<?php
declare(strict_types=1);

namespace Integration\Stubs;

use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\PersistGatewayInterface;
use App\AppCore\Domain\Repository\TestEntity;

class TestPersistGateway implements PersistGatewayInterface
{

    /** @var array */
    private $collection = [];

    public function nextId()
    {
        return 'id';
    }

    public function persist(EntityInterface $testEntity)
    {
        foreach ($this->collection as &$item){
            /** @var TestEntity $item */
            if($testEntity->id() === $item->id()){
                $item = $testEntity;
            }
        }
        if(null === $testEntity->id()){
            $testEntity = new TestEntity($testEntity->uuid(), $testEntity->requestedBody(), $this->nextId());
        }
        if(0 === \count($this->filterCollectionById($testEntity->id()))){
            $this->collection[] = $testEntity;
        }
    }

    public function getAll()
    {
        return $this->collection;
    }

    public function find(string $id)
    {
        return $this->filterCollectionById($id)[0];
    }

    /**
     * @param string $id
     *
     * @return array
     */
    private function filterCollectionById(string $id): array
    {
        return \array_filter($this->collection, function (EntityInterface $entity) use ($id) {
            return $id === $entity->id();
        });
    }

    public function findByHash(string $uuid)
    {
        return \array_filter($this->collection, function (TestEntity $entity) use ($uuid) {
            return $uuid === $entity->uuid();
        })[0];
    }
}
