<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

interface CommandRunnerInterface
{
    public function run(CommandsCollectionInterface  $commandsCollection);
}
