<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

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
