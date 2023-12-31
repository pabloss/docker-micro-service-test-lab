<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\uServiceInterface;

interface uServiceRepositoryInterface
{
    public function persist(uServiceInterface $domain);

    public function all();

    public function find(string $id);

    public function findByHash(string $hash);
}
