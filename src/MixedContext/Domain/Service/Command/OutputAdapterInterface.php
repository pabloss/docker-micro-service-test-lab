<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command;

interface OutputAdapterInterface
{
    public function writeln(string $message, string $dir);
    public function createEntry(string $message, string $dir): array;
}
