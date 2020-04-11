<?php
declare(strict_types=1);

namespace Integration\Stubs;

use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\PersistGatewayInterface;

class PersistGateway implements PersistGatewayInterface
{

    /** @var array */
    private $collection = [];

    public function nextId()
    {
        return 'id';
    }

    public function getAll()
    {
        return $this->collection;
    }

    public function persist(EntityInterface $uServiceEntity)
    {
        foreach ($this->collection as &$item){
            /** @var EntityInterface $item */
            if($uServiceEntity->id() === $item->id()){
                $item = $uServiceEntity;
            }
        }
        if(0 === \count($this->filterCollectionById($uServiceEntity->id()))){
            $this->collection[] = $uServiceEntity;
        }
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

}
