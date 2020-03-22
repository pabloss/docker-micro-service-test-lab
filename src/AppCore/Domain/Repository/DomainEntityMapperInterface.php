<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Actors\uServiceInterface;

interface DomainEntityMapperInterface
{
    public function domain2Entity(string $id, uServiceInterface $domain): EntityInterface;
}
