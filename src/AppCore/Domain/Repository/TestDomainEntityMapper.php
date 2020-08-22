<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\Test;

/**
 *
 * 1. SRP - OK
 * 2. OCP - OK
 * 3. LSP - don't know
 * 4. SIP - OK
 * 5. DIP - OK
 * Class DomainEntityMapper
 *
 * @package App\AppCore\Domain\Repository
 */
class TestDomainEntityMapper implements TestDomainEntityMapperInterface
{
    public function domain2Entity(?string $id, Test $test)
    {
        return new TestEntity($test->getUuid(), $test->getRequestedBody(), $id);
    }

    public function entity2Domain(TestEntity $testEntity)
    {
        return new Test($testEntity->uuid(), $testEntity->requestedBody());
    }
}
