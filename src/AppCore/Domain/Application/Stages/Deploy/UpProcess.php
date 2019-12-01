<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application\Stages\Deploy;

use App\AppCore\Domain\Application\DeployProcessApplication;
use App\AppCore\Domain\Service\Command\CommandProcessor;

class UpProcess
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
     * RunProcess constructor.
     * @param CommandProcessor $commandProcessor
     * @param CommandStringFactory $factory
     */
    public function __construct(CommandProcessor $commandProcessor, CommandStringFactory $factory)
    {
        $this->commandProcessor = $commandProcessor;
        $this->factory = $factory;
    }

    /**
     * @param $payload
     * @throws \ZMQSocketException
     */
    public function __invoke($payload)
    {
        $dockerComposeConfFiles = json_decode(file_get_contents($payload["file"]."/zip.json"), true);
        foreach ($dockerComposeConfFiles as $dockerComposeConfFile) {
            $this->commandProcessor->processRealTimeOutput(
                $this->factory->getUpCommandStr(
                    $payload[DeployProcessApplication::FILE_KEY] . "/" . $dockerComposeConfFile
                ) . " ".CommandProcessor::STDERR . ">&". CommandProcessor::STDOUT,
                \basename($payload[DeployProcessApplication::INDEX_KEY])
            );
        }

    }
}
