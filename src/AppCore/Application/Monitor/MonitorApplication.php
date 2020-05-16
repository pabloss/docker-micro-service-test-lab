<?php
declare(strict_types=1);

namespace App\AppCore\Application\Monitor;

use App\AppCore\Domain\Service\Command\CommandRunnerInterface;
use App\AppCore\Domain\Service\Command\CommandsCollectionInterface;

class MonitorApplication
{
    /**
     * @var \App\AppCore\Domain\Service\Command\CommandRunnerInterface
     */
    private $commandRunner;

    public function __construct(CommandRunnerInterface $commandRunner)
    {
        $this->commandRunner = $commandRunner;
    }

    public function run(CommandsCollectionInterface $reveal)
    {
        $this->commandRunner->run($reveal);
    }
}
