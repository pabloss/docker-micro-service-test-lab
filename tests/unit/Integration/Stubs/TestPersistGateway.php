<?php
declare(strict_types=1);

namespace Integration\Stubs;

use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\TestEntityInterface;
use App\AppCore\Domain\Repository\TestRepositoryInterface;

class TestPersistGateway implements TestRepositoryInterface
{

    /** @var array */
    private $collection = [];

    public function nextId()
    {
        return 'id';
    }

    public function persist(TestEntityInterface $testEntity, ?string $nextId)
    {
        foreach ($this->collection as &$item){
            if($testEntity->getId() === $item->getId()){
                $item = $testEntity;
            }
        }
        if(null === $testEntity->getId()){
            $testEntity->setId($this->nextId());
        }
        if(0 === \count($this->filterCollectionById($testEntity->getId()))){
            $this->collection[] = $testEntity;
        }
    }

    public function all()
    {
        return $this->collection;
    }

    public function find($id)
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
            return $id === $entity->getId();
        });
    }

    public function findByHash(string $uuid)
    {
        return \array_filter($this->collection, function (TestEntityInterface $entity) use ($uuid) {
            return $uuid === $entity->getUuid();
        })[0];
    }
}
