<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Files\Dir;
use App\AppCore\Domain\Service\Files\Unpack;
use App\Framework\Service\Files\UploadedFile;

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
    }

    public function deploy(string $targetDir)
    {
        $tag = 'tag' . \uniqid();
        $containerName = 'container' . \uniqid();

        $this->commandProcessor->processRealTimeOutput(
            $this->factory->getBuildCommandStr(
                $tag,
                $this->dir->findParentDir($targetDir, 'Dockerfile')
            )
        );

        $this->commandProcessor->processRealTimeOutput(
            $this->factory->getRunCommandStr(
                $containerName,
                $tag
            )
        );
    }
}
