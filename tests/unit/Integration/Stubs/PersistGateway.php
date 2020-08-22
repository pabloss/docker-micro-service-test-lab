<?php
declare(strict_types=1);

namespace Integration\Stubs;

use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\PersistGatewayInterface;
use App\AppCore\Domain\Repository\uServiceEntity;

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
        if(null === $uServiceEntity->id()){
            $uServiceEntity = $this->createNewEntity($uServiceEntity);
        }

        if(0 === \count($this->filterCollectionById($uServiceEntity->id()))){
            $this->collection[] = $this->createNewEntity($uServiceEntity);
        }
    }

    public function find(string $id)
    {
        return $this->filterCollectionById($id)[0];
    }

    public function findByHash(string $id)
    {
        return $this->filterCollectionByHash($id)[0];
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
    /**
     * @param string $hash
     *
     * @return array
     */
    private function filterCollectionByHash(string $hash): array
    {
        return \array_filter($this->collection, function (uServiceEntity $entity) use ($hash) {
            return $hash === $entity->uuid();
        });
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

    /**
     * @param EntityInterface $uServiceEntity
     *
     * @return uServiceEntity
     */
    private function createNewEntity(EntityInterface $uServiceEntity): uServiceEntity
    {
        $newUServiceEntity = new uServiceEntity(
            $uServiceEntity->movedToDir(),
            $uServiceEntity->file(),
            $this->getUuidFromDir($uServiceEntity->movedToDir()), $this->nextId()
        );
        if(null !== $uServiceEntity->getTest()){
            $newUServiceEntity->setTest( $uServiceEntity->getTest());
        }
        return $newUServiceEntity;
    }

}
