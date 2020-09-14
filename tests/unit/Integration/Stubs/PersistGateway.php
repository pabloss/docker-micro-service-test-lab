<?php
declare(strict_types=1);

namespace Integration\Stubs;

use App\AppCore\Domain\Actors\uServiceInterface;
use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\Framework\Entity\Test;
use App\Framework\Entity\UService;
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
            $test = $uServiceEntity->getTests()->first();
            $uServiceEntity = $factory->createService($uServiceEntity->getFile(), $uServiceEntity->getMovedToDir());
            if($test instanceof Test){
                $uServiceEntity->addTest($test);
            }
            $uServiceEntity->setId(1);
        }

        $uServiceEntity->setUuid($this->getUuidFromDir(\dirname($uServiceEntity->getFile())));
        if(0 === \count($this->filterCollectionById((string)$uServiceEntity->getId()))){
            $this->collection[] = $uServiceEntity;
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
            return $id === (string) $entity->getId();
        });
    }
    /**
     * @param string $hash
     *
     * @return array
     */
    private function filterCollectionByHash(string $hash): array
    {
        return \array_filter($this->collection, function (UService $entity) use ($hash) {
            return $hash === $entity->getUuid();
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

//    /**
//     * @param EntityInterface $uServiceEntity
//     *
//     * @return UService
//     */
//    private function createNewEntity(EntityInterface $uServiceEntity): UService
//    {
//        $newUServiceEntity = new uServiceEntity(
//            $uServiceEntity->movedToDir(),
//            $uServiceEntity->file(),
//            $this->getUuidFromDir($uServiceEntity->movedToDir()), $this->nextId()
//        );
//        if(null !== $uServiceEntity->getTest()){
//            $newUServiceEntity->setTest( $uServiceEntity->getTest());
//        }
//        return $newUServiceEntity;
//    }

}
