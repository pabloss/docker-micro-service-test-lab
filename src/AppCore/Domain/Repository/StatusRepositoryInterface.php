<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\Framework\Entity\Status;

interface StatusRepositoryInterface
{
    public function save(Status $entity);

    public function get(int $id);

    public function findByHash(string $hash);
}
