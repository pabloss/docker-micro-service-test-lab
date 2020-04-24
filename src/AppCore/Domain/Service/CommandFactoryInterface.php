<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

interface CommandFactoryInterface
{
    public function createCommand(string $type, string $firstArg, string $secondArg);
    public function createCollection(array $collection);
}
