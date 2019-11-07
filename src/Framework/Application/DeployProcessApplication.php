<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Context;
use App\AppCore\Domain\Service\Files\Unpack;
use App\Framework\Command\SocketOutputAdapter;
use App\Framework\Service\Files\Params;
use App\Framework\Service\Files\UploadedFile;

class DeployProcessApplication
{
    const FILES = 'files';
    /**
     * @var Context
     */
    private $context;

    /**
     * @var Unpack
     */
    private $unpack;

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
     * @param Context $context
     * @param Unpack $unpack
     * @param string $unpacked_directory
     * @param string $uploaded_directory
     */
    public function __construct(
        Context $context,
        Unpack $unpack,
        string $unpacked_directory,
        string $uploaded_directory
    ) {
        $this->context = $context;
        $this->unpack = $unpack;
        $this->unpacked_directory = $unpacked_directory;
        $this->uploaded_directory = $uploaded_directory;
    }


    public function deploy(array $filesBag)
    {
        $commandProcessor = new CommandProcessor(new SocketOutputAdapter($this->context));
        $tag = 'tag' . \uniqid();
        $containerName = 'container' . \uniqid();
        $commandProcessor->processRealTimeOutput(
            $this->getBuildCommandStr(
                $tag,
                $this->unpack->getTargetDir($this->unpacked_directory, $this->uploadedFile($filesBag)->getTargetFile()) .
                '/docker_build/bulletin-board-app/'
            )
        );
        $commandProcessor->processRealTimeOutput(
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
     * @return UploadedFile
     */
    protected function uploadedFile(array $filesBag): UploadedFile
    {
        $this->createParams($filesBag);
        return UploadedFile::instance(Params::getInstance());
    }


    /**
     * @param array $filesBag
     */
    protected function createParams(array $filesBag): void
    {
        Params::createInstance($this->uploaded_directory, $filesBag[self::FILES]);
    }
}
