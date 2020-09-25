<?php
declare(strict_types=1);

namespace App\AppCore\Application\Monitor;

use App\AppCore\Domain\Service\Deploy\Command\WatcherInterface;

interface FetcherInterface
{
    public function exec(string $command, WatcherInterface $output);
}
