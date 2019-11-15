<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command;

interface FetchOutInterface
{
    public function fetchedOut($pipes): bool;
}
