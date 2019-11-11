<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Files\Unpack;
use App\Framework\Service\Files\UploadedFile;

class DeployProcessApplication
{
    /**
     * @var Unpack
     */
    private $unpack;

    /**
     * @var CommandProcessor
     */
    private $commandProcessor;

    /**
     * @var string
     */
    private $unpacked_directory;

    /**
     * @var string
     */
    private $uploaded_directory;

    /**
     * DeployProcessApplication constructor.
     * @param Unpack $unpack
     * @param CommandProcessor $commandProcessor
     * @param string $unpacked_directory
     * @param string $uploaded_directory
     */
    public function __construct(
        Unpack $unpack,
        CommandProcessor $commandProcessor,
        string $unpacked_directory,
        string $uploaded_directory
    ) {
        $this->unpack = $unpack;
        $this->unpacked_directory = $unpacked_directory;
        $this->uploaded_directory = $uploaded_directory;
        $this->commandProcessor = $commandProcessor;
    }

    public function deploy(array $filesBag)
    {
        $tag = 'tag' . \uniqid();
        $containerName = 'container' . \uniqid();

        $this->commandProcessor->processRealTimeOutput(
            $this->getBuildCommandStr(
                $tag,
                $this->getTargetDir($filesBag) .
                '/docker_build/bulletin-board-app/'
            )
        );

        $this->commandProcessor->processRealTimeOutput(
            $this->getRunCommandStr(
                $containerName,
                $tag
            )
        );
    }

    /**
     * @param string $tag
     * @param string $dockerFile
     * @return string
     */
    protected function getBuildCommandStr(string $tag, string $dockerFile): string
    {
        return
            "docker image build -t {$tag} {$dockerFile}" .
            " " .
            CommandProcessor::getBashOutRedirect(CommandProcessor::STDERR, CommandProcessor::STDOUT);
    }

    /**
     * @param string $containerName
     * @param string $tag
     * @return string
     */
    protected function getRunCommandStr(string $containerName, string $tag): string
    {
        // docker image build -t {tag} .
        // docker container run --publish {out_port}:{in_port} --detach --name {container_name} {tag}
        return
            "docker container run --detach --name {$containerName} {$tag}" .
            " " .
            CommandProcessor::getBashOutRedirect(CommandProcessor::STDERR, CommandProcessor::STDOUT);
    }

    /**
     * @param array $filesBag
     * @return string
     */
    private function getTargetFile(array $filesBag): string
    {
        return UploadedFile::fromTargetDirAndBaseUploadedFile($this->uploaded_directory,
            $filesBag[UploadedFile::FILES])->getTargetFile();
    }

    /**
     * @param array $filesBag
     * @return string|\ZipArchive
     */
    private function getTargetDir(array $filesBag)
    {
        return $this->unpack->getTargetDir($this->unpacked_directory, $this->getTargetFile($filesBag));
    }
}
