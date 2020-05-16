<?php
declare(strict_types=1);

namespace App\Framework\Service\Command\Fetcher;

use App\AppCore\Domain\Service\OutPutInterface;

interface FetcherInterface
{
    public function exec(string $command, OutPutInterface $output);
}
