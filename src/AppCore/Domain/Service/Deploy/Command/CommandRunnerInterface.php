<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Deploy\Command;

interface CommandRunnerInterface
{
    public function run(CommandsCollectionInterface $commandsCollection);
}
