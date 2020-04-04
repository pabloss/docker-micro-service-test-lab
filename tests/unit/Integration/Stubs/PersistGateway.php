<?php
declare(strict_types=1);

namespace Integration\Stubs;

use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\PersistGatewayInterface;

class PersistGateway implements PersistGatewayInterface
{

    /** @var array */
    private $collection;

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
        $this->collection[] = $uServiceEntity;
    }

    public function find(string $id)
    {
        return \array_filter($this->collection, function (EntityInterface $entity) use ($id){return $id === $entity->id();})[0];
    }

}
