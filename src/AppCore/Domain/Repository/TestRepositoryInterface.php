<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

interface TestRepositoryInterface
{
    public function persist(TestEntityInterface $domain);

    public function all();

    public function find($nextId);

    public function findByHash(string $uuid);
}
