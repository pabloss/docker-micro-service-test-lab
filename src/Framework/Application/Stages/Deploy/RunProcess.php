<?php
declare(strict_types=1);

namespace App\Framework\Application\Stages\Deploy;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\Framework\Application\CommandStringFactory;

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

    public function __invoke($payload)
    {
        $this->commandProcessor->processRealTimeOutput(
            $this->factory->getRunCommandStr(
                $payload['container'],
                $payload['tag']
            )
        );
    }
}
