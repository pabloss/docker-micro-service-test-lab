<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Deploy\Build;

use App\AppCore\Domain\Service\Deploy\Command\CommandsCollectionInterface;

interface BuildServiceInterface
{
    public function build(CommandsCollectionInterface $collection);
}
