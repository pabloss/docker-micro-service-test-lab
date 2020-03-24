<?php
declare(strict_types=1);

namespace Integration\Stubs;

use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\PersistGatewayInterface;
use App\AppCore\Domain\Repository\uServiceEntity;

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
}
