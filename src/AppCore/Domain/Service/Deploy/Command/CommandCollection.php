<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Deploy\Command;

use ArrayObject;

class CommandCollection extends ArrayObject implements CommandsCollectionInterface
{

    public function addCommand(CommandInterface $command)
    {
        $this->append($command);
    }

    public function getCommand(int $index): CommandInterface
    {
        return $this->offsetGet($index);
    }
}
