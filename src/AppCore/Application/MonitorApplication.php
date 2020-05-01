<?php
declare(strict_types=1);

namespace App\AppCore\Application;

use App\AppCore\Domain\Service\CommandRunnerInterface;
use App\AppCore\Domain\Service\CommandsCollectionInterface;

class MonitorApplication
{
    /**
     * @var CommandRunnerInterface
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
