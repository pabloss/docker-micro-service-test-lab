<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Build;

use App\AppCore\Domain\Service\Command\CommandsCollectionInterface;

interface BuildServiceInterface
{
    public function build(CommandsCollectionInterface $collection);
}
