<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Files\Dir;
use App\Framework\Application\Stages\Deploy\BuildProcess;
use App\Framework\Application\Stages\Deploy\CommandStringFactory;
use App\Framework\Application\Stages\Deploy\RunProcess;
use League\Pipeline\Pipeline;

class DeployProcessApplication
{
    /**
     * @var CommandProcessor
     */
    private $commandProcessor;

    /**
     * @var CommandStringFactory
     */
    private $factory;

    /**
     * @var Dir
     */
    private $dir;

    /**
     * @var Pipeline
     */
    private $pipe;

    /**
     * DeployProcessApplication constructor.
     * @param CommandProcessor $commandProcessor
     * @param CommandStringFactory $factory
     * @param Dir $dir
     */
    public function __construct(CommandProcessor $commandProcessor, CommandStringFactory $factory, Dir $dir)
    {
        $this->commandProcessor = $commandProcessor;
        $this->factory = $factory;
        $this->dir = $dir;
        $this->pipe = (new Pipeline())
            ->pipe(new BuildProcess($this->commandProcessor, $this->factory))
            ->pipe(new RunProcess($this->commandProcessor, $this->factory));
    }

    public function deploy(string $targetDir)
    {
        $this->pipe->process([
            'tag' => 'tag' . \uniqid(),
            'container' => 'container' . \uniqid(),
            'target_dir' => $this->dir->findParentDir($targetDir, 'Dockerfile'),
            'index' => $targetDir,
        ]);
    }
}
