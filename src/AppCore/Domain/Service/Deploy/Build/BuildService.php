<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Deploy\Build;

use App\AppCore\Domain\Service\Deploy\Command\CommandRunnerInterface;
use App\AppCore\Domain\Service\Deploy\Command\CommandsCollectionInterface;

class BuildService implements BuildServiceInterface
{
    /**
     * @var CommandRunnerInterface
     */
    private $commandRunner;

    public function __construct(CommandRunnerInterface $commandRunner)
    {
        $this->commandRunner = $commandRunner;
    }

    public function build(CommandsCollectionInterface $collection)
    {
        $this->commandRunner->run($collection);
    }
}
