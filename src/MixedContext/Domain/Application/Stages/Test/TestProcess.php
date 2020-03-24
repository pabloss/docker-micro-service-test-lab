<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application\Stages\Test;

use App\AppCore\Domain\Application\TestProcessApplication;
use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Command\CommandProcessorInterface;

class TestProcess implements TestProcessInterface
{
    /**
     * @var CommandProcessorInterface
     */
    private $commandProcessor;


    /**
     * RunProcess constructor.
     *
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
            $this->getTestCommandStr(
                $this->getTestFilePath($payload)
            ),
            $this->getIndex($payload)
        );
    }

    /**
     * @param string $testFilePath
     * @return string
     */
    public function getTestCommandStr(string $testFilePath): string
    {
        // /bin/bash {$confFile}
        return
            "/bin/bash {$testFilePath}" ;
    }


    /**
     * @param $payload
     * @return mixed
     */
    private function getTestFilePath($payload)
    {
        return $payload[TestProcessApplication::FILE_KEY];
    }

    /**
     * @param $payload
     * @return string
     */
    private function getIndex($payload): string
    {
        return \basename($payload[TestProcessApplication::INDEX_KEY]);
    }
}