<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application;

use App\AppCore\Domain\Application\Stages\Deploy\CommandStringFactory;
use App\AppCore\Domain\Application\Stages\Test\TestProcess;
use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Files\Dir;
use League\Pipeline\Pipeline;

class TestProcessApplication
{
    const INDEX_KEY = 'index';
    const FILE_KEY = 'file';

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
            ->pipe(new TestProcess($this->commandProcessor, $this->factory))
        ;
    }

    public function deploy(string $targetDir)
    {
        $this->pipe->process([
            self::FILE_KEY => $this->dir->findFile(
                 $targetDir,
                'test.sh'
            ),
            self::INDEX_KEY =>      $targetDir,
        ]);
    }
}
