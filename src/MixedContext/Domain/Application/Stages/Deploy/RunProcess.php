<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application\Stages\Deploy;

use App\AppCore\Domain\Application\DeployProcessApplication;
use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Command\CommandProcessorInterface;

class RunProcess implements RunProcessInterface
{
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
        $this->commandProcessor->processRealTimeOutput(
            $this->getRunCommandStr(
                $this->getContainerName($payload),
                $this->getTag($payload)
            ),
            $this->getIndex($payload)
        );
    }

    /**
     * @param string $containerName
     * @param string $tag
     * @return string
     */
    public function getRunCommandStr(string $containerName, string $tag): string
    {
        // docker image build -t {tag} .
        // docker container run --publish {out_port}:{in_port} --detach --name {container_name} {tag}
        return
            "docker container run --detach --name {$containerName} {$tag}" ;
    }

    /**
     * @param $payload
     * @return mixed
     */
    private function getContainerName($payload)
    {
        return $payload[DeployProcessApplication::CONTAINER_KEY];
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
     * @return string
     */
    private function getIndex($payload): string
    {
        return \basename($payload[DeployProcessApplication::INDEX_KEY]);
    }
}
