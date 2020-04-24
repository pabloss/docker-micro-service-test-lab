<?php
declare(strict_types=1);

namespace App\Framework\Service\Command;

use App\AppCore\Domain\Service\CommandInterface;
use App\AppCore\Domain\Service\CommandsCollectionInterface;
use phpDocumentor\Reflection\Types\This;

class CommandCollection extends \ArrayObject implements CommandsCollectionInterface
{

    public function addCommand(CommandInterface $command)
    {
        $this->append($command);
    }

    public function getCommand(int $index): CommandInterface
    {
        // todo: write test when you force to get non existed index
        return $this->offsetGet($index);
    }



}
