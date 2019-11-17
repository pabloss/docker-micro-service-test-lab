<?php
declare(strict_types=1);

namespace App\Framework\Application\Stages\Deploy;

use App\AppCore\Domain\Service\Command\CommandProcessor;

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

    /**
     * @param $payload
     * @return mixed
     * @throws \ZMQSocketException
     */
    public function __invoke($payload)
    {
        $this->commandProcessor->processRealTimeOutput(
            $this->factory->getBuildCommandStr(
                $payload['tag'],
                $payload['target_dir']
            ),
            \basename($payload['target_dir'])
        );
        return $payload;
    }

}
