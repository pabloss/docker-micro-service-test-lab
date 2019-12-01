<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application;

use App\AppCore\Domain\Application\Stages\Deploy\UpProcess;
use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Files\Dir;
use League\Pipeline\Pipeline;

class DeployProcessApplication
{
    const TARGET_DIR_KEY = 'target_dir';
    const INDEX_KEY = 'index';
    const CONTAINER_KEY = 'container';
    const TAG_KEY = 'tag';
    const FILE_KEY = 'file';

    /**
     * @var CommandProcessor
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
     * @param CommandProcessor $commandProcessor
     * @param Dir $dir
     */
    public function __construct(CommandProcessor $commandProcessor,  Dir $dir)
    {
        $this->commandProcessor = $commandProcessor;
        $this->dir = $dir;
        $this->pipe = (new Pipeline())
            ->pipe(new UpProcess($this->commandProcessor))
        ;
    }

    public function run(string $targetDir)
    {
        $this->pipe->process([
            self::FILE_KEY => $this->dir->findParentDir($targetDir, 'zip.json'),
            self::INDEX_KEY => $targetDir,
        ]);
    }
}
