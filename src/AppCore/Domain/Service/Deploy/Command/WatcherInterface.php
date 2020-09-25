<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Deploy\Command;

interface WatcherInterface
{
    public function writeln(string $output);
}
