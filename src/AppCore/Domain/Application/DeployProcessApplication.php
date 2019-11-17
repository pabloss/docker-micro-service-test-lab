<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application;

use App\AppCore\Domain\Application\Stages\Deploy\BuildProcess;
use App\AppCore\Domain\Application\Stages\Deploy\CommandStringFactory;
use App\AppCore\Domain\Application\Stages\Deploy\RunProcess;
use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Files\Dir;
use League\Pipeline\Pipeline;

class DeployProcessApplication
{
    const TARGET_DIR_KEY = 'target_dir';
    const INDEX_KEY = 'index';
    const CONTAINER_KEY = 'container';
    const TAG_KEY = 'tag';

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
            self::TAG_KEY =>        'tag' . \uniqid(),
            self::CONTAINER_KEY =>  'container' . \uniqid(),
            self::TARGET_DIR_KEY => $this->dir->findParentDir($targetDir, 'Dockerfile'),
            self::INDEX_KEY =>      $targetDir,
        ]);
    }
}
