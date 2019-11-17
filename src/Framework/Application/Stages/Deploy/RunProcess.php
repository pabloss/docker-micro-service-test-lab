<?php
declare(strict_types=1);

namespace App\Framework\Application\Stages\Deploy;

use App\AppCore\Domain\Service\Command\CommandProcessor;

class RunProcess
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
            $this->factory->getRunCommandStr(
                $payload['container'],
                $payload['tag']
            ),
            \basename($payload['target_dir'])
        );
    }
}
