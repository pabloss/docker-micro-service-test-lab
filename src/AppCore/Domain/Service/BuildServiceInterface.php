<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

interface BuildServiceInterface
{
    public function build(CommandsCollectionInterface $collection);
}
