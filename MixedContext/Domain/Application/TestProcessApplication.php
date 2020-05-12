<?php
declare(strict_types=1);

namespace App\MixedContext\Domain\Application;

use App\MixedContext\Domain\Application\Stages\Test\TestProcess;
use App\MixedContext\Domain\Service\Command\CommandProcessorInterface;
use App\MixedContext\Domain\Service\Files\Dir;
use League\Pipeline\Pipeline;

class TestProcessApplication implements TestProcessApplicationInterface
{
    const INDEX_KEY = 'index';
    const FILE_KEY = 'file';

    /**
     * @var CommandProcessorInterface
     */
    private $commandProcessor;

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
     *
     * @param CommandProcessorInterface $commandProcessor
     * @param Dir                       $dir
     */
    public function __construct(CommandProcessorInterface $commandProcessor, Dir $dir)
    {
        $this->commandProcessor = $commandProcessor;
        $this->dir = $dir;
        $this->pipe = (new Pipeline())
            ->pipe(new TestProcess($this->commandProcessor))
        ;
    }

    public function run(string $targetDir)
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
