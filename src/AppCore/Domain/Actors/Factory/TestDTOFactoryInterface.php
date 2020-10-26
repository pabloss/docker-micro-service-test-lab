<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors\Factory;

use App\AppCore\Domain\Actors\TestDTO;
use App\AppCore\Domain\Repository\TestEntityInterface;

interface TestDTOFactoryInterface
{
    public function create(TestEntityInterface $testEntity, string $requestContent): TestDTO;
}
