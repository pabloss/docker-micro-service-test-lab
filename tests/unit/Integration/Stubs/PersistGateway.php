<?php
declare(strict_types=1);

namespace Integration\Stubs;

use App\AppCore\Domain\Actors\uServiceInterface;
use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\Framework\Factory\EntityFactory;

class PersistGateway implements uServiceRepositoryInterface
{

    /** @var array */
    private $collection = [];

    public function nextId()
    {
        return 'id';
    }

    public function all()
    {
        return $this->collection;
    }

    public function persist(uServiceInterface $uServiceEntity, ?string $id)
    {
        foreach ($this->collection as &$item){
            /** @var EntityInterface $item */
            if($uServiceEntity->getId() === $item->getId()){
                $item = $uServiceEntity;
            }
        }
        $factory =new EntityFactory();
        if(null === $uServiceEntity->getId()){
            $uServiceEntity = $factory->createService($uServiceEntity->getFile(), $uServiceEntity->getMovedToDir());
            $uServiceEntity->setId(1);
        }

        if(0 === \count($this->filterCollectionById((string)$uServiceEntity->getId()))){
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
            return $id === (string) $entity->getId();
        });
    }

}
