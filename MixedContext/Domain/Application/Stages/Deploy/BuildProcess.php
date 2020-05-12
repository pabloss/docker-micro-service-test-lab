<?php
declare(strict_types=1);

namespace App\MixedContext\Domain\Application\Stages\Deploy;

use App\MixedContext\Domain\Application\DeployProcessApplication;
use App\MixedContext\Domain\Service\Command\CommandProcessorInterface;

class BuildProcess implements BuildProcessInterface
{
    /**
     * @var CommandProcessorInterface
     */
    private $commandProcessor;

    /**
     * BuildProcess constructor.
     * @param CommandProcessorInterface $commandProcessor
     */
    public function __construct(CommandProcessorInterface $commandProcessor)
    {
        $this->commandProcessor = $commandProcessor;
    }

    /**
     * @param $payload
     * @return mixed
     * @throws \ZMQSocketException
     */
    public function __invoke($payload)
    {
        $this->commandProcessor->processRealTimeOutput(
            $this->getBuildCommandStr(
                $this->getTag($payload),
                $this->getDockerFile($payload)
            ),
            $this->getIndex($payload)
        );
        return $payload;
    }

    public function getBuildCommandStr(string $tag, string $dockerFile): string
    {
        return
            "docker image build -t {$tag} {$dockerFile}" ;
    }

    /**
     * @param $payload
     * @return mixed
     */
    private function getTag($payload)
    {
        return $payload[DeployProcessApplication::TAG_KEY];
    }

    /**
     * @param $payload
     * @return mixed
     */
    private function getDockerFile($payload)
    {
        return $payload[DeployProcessApplication::TARGET_DIR_KEY];
    }

    /**
     * @param $payload
     * @return string
     */
    private function getIndex($payload): string
    {
        return \basename($payload[DeployProcessApplication::INDEX_KEY]);
    }

}
