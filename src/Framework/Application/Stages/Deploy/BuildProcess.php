<?php
declare(strict_types=1);

namespace App\Framework\Application\Stages\Deploy;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\Framework\Application\CommandStringFactory;

class BuildProcess
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
     * BuildProcess constructor.
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
            $this->factory->getBuildCommandStr(
                $payload['tag'],
                $payload['target_dir']
            )
        );
        return $payload;
    }

}
