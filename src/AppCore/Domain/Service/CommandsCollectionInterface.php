<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

interface CommandsCollectionInterface
{
    public function addCommand(CommandInterface $command);

    public function getCommand(int $index): CommandInterface;
    public function count();
}
