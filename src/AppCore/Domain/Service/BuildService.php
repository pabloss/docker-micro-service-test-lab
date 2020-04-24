<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

class BuildService implements BuildServiceInterface
{
    /**
     * @var CommandsCollectionInterface
     */
    private $commandCollection;

    /**
     * @var CommandRunnerInterface
     */
    private $commandRunner;

    /**
     * BuildService constructor.
     *
     * @param CommandsCollectionInterface $commandCollection
     * @param CommandRunnerInterface      $commandRunner
     */
    public function __construct(CommandsCollectionInterface $commandCollection, CommandRunnerInterface $commandRunner)
    {
        $this->commandCollection = $commandCollection;
        $this->commandRunner = $commandRunner;
    }

    public function build()
    {
        $this->commandRunner->run($this->commandCollection);
    }
}
