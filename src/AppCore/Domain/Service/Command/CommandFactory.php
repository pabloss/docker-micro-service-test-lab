<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command;

class CommandFactory implements CommandFactoryInterface
{
    public function createCommand(string $type, string $firstArg, string $secondArg)
    {
        switch ($type){
            case 'build':
                return new BuildCommand($firstArg, $secondArg);
            case 'run':
                return new RunCommand($firstArg, $secondArg);
        }
    }

    public function createCollection(array $collection)
    {
        $commandCollection = new CommandCollection();
        foreach ($collection as $command){
            $commandCollection->addCommand($command);
        }
        return $commandCollection;
    }

}
