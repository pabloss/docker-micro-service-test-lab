<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\Test;

interface TestDomainEntityMapperInterface
{
    public function domain2Entity(?string $id, Test $test);
    public function entity2Domain(TestEntity $testEntity);
}
