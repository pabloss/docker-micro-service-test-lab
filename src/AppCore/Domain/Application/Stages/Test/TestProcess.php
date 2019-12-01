<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application\Stages\Test;

use App\AppCore\Domain\Application\TestProcessApplication;
use App\AppCore\Domain\Application\Stages\Deploy\CommandStringFactory;
use App\AppCore\Domain\Service\Command\CommandProcessor;

class TestProcess
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
        $this->commandProcessor->processRealTimeOutput(
            $this->factory->getTestCommandStr(
                $payload[TestProcessApplication::FILE_KEY]
            ),
            \basename($payload[TestProcessApplication::INDEX_KEY])
        );
    }
}
