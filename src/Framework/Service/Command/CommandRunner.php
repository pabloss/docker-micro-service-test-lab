<?php
declare(strict_types=1);

namespace App\Framework\Service\Command;

use App\AppCore\Domain\Service\CommandInterface;
use App\AppCore\Domain\Service\CommandRunnerInterface;
use App\AppCore\Domain\Service\CommandsCollectionInterface;

class CommandRunner implements CommandRunnerInterface
{

    public function run(CommandsCollectionInterface $commandsCollection)
    {
        // todo: only when we implement command monitor we should take output and return value of command
        for($i = 0; $i < $commandsCollection->count(); $i++){
            $this->runOneCommand($commandsCollection->getCommand($i));
        }
    }


    private function runOneCommand(CommandInterface $command)
    {
        \exec($command->command(), $data, $returnCode);
    }
}
