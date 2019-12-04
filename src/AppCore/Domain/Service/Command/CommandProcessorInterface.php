<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command;

interface CommandProcessorInterface
{
    public function processRealTimeOutput(string $command, string $dir);
    public function fetchedOut($pipes, int $stdCode, string $dir): bool;
}