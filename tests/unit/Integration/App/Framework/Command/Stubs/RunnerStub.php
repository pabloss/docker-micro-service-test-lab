<?php
declare(strict_types=1);

namespace App\Tests\unit\Integration\App\Framework\Command\Stubs;

use App\AppCore\Domain\Service\CommandInterface;
use App\AppCore\Domain\Service\CommandsCollectionInterface;
use App\Framework\Service\Command\CommandRunner;

class RunnerStub extends CommandRunner
{
    public static $counter = 0;
    public function __construct()
    {

    }

    public function run(CommandsCollectionInterface $collection)
    {

        for($i = 0; $i < $collection->count(); $i++){
            $this->runOneCommand($collection->getCommand($i));
            ++self::$counter;
        }
    }

    private function runOneCommand(CommandInterface $command)
    {
        $command->command();
    }
}
