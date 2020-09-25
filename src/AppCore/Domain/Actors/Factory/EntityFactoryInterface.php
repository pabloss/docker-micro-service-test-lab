<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors\Factory;

use App\AppCore\Domain\Actors\StatusEntityInterface;
use App\AppCore\Domain\Actors\TestDTO;
use App\AppCore\Domain\Repository\TestEntityInterface;
use App\AppCore\Domain\Repository\uServiceEntityInterface;

interface EntityFactoryInterface
{
    public function createService(string $file, string $movedToDir): uServiceEntityInterface;
    public function createTest(TestDTO $testDTO): TestEntityInterface;
    public function createStatusEntity(string $uuid, string $statusString, \DateTime $now): StatusEntityInterface;
}
