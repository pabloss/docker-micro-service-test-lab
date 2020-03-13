<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

// todo: move outside domain
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

    public function persist(uServiceEntity $uServiceEntity)
    {
        $this->collection[] = $uServiceEntity;
    }
}
