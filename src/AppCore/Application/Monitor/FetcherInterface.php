<?php
declare(strict_types=1);

namespace App\AppCore\Application\Monitor;

use App\AppCore\Domain\Service\Command\OutPutInterface;

interface FetcherInterface
{
    public function exec(string $command, OutPutInterface $output);
}
