<?php
declare(strict_types=1);

namespace App\MixedContext\Domain\Application\Stages\Deploy;

use App\MixedContext\Domain\Application\DeployProcessApplication;
use App\MixedContext\Domain\Service\Command\CommandProcessor;
use App\MixedContext\Domain\Service\Command\CommandProcessorInterface;

class UpProcess implements UpProcessInterface
{
    const FILE_KEY = "file";
    const PACKAGE_CONF_FILE_NAME = "zip.json";
    const STDERR_TO_STDOUT_REDIRECTION = CommandProcessor::STDERR . ">&" . CommandProcessor::STDOUT;

    /**
     * @var CommandProcessorInterface
     */
    private $commandProcessor;

    /**
     * RunProcess constructor.
     * @param CommandProcessorInterface $commandProcessor
     */
    public function __construct(CommandProcessorInterface $commandProcessor)
    {
        $this->commandProcessor = $commandProcessor;
    }

    /**
     * @param $payload
     * @throws \ZMQSocketException
     */
    public function __invoke($payload)
    {
        foreach ($this->getDockerComposeFileNames($payload) as $dockerComposeFileName) {
            $this->commandProcessor->processRealTimeOutput(
                $this->getUpCommandStr(
                    $this->getDockerComposeConfPath($payload, $dockerComposeFileName)
                ) .
                " " .
                self::STDERR_TO_STDOUT_REDIRECTION,
                $this->getIndex($payload)
            );
        }

    }
    /**
     * @param string $confFile
     * @return string
     */
    public function getUpCommandStr(string $confFile): string
    {
        // docker-compose -f {$confFile}  up -d --force-recreate
        return
            "docker-compose -f {$confFile}  up -d --force-recreate" ;
    }

    /**
     * @param $payload
     * @param $dockerComposeConfFile
     * @return string
     */
    private function getDockerComposeConfPath($payload, $dockerComposeConfFile): string
    {
        return $payload[DeployProcessApplication::FILE_KEY] . "/" . $dockerComposeConfFile;
    }

    /**
     * @param $payload
     * @return string
     */
    private function getIndex($payload): string
    {
        return \basename($payload[DeployProcessApplication::INDEX_KEY]);
    }

    /**
     * @param $payload
     * @return array
     */
    private function getDockerComposeFileNames($payload): array
    {
        return json_decode(file_get_contents($payload[self::FILE_KEY] . "/" . self::PACKAGE_CONF_FILE_NAME), true);
    }
}