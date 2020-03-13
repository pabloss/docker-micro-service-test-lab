<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\uService;

interface DomainEntityMapperInterface
{
    public function domain2Entity(string $id, uService $domain): uServiceEntity;
}
