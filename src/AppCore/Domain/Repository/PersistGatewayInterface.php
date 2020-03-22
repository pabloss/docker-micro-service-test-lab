<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

interface PersistGatewayInterface
{
    public function nextId();
    public function getAll();
    public function persist(EntityInterface $uServiceEntity);
}
