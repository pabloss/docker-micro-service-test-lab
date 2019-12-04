<?php
declare(strict_types=1);

namespace App\Framework\Command;

use App\AppCore\Domain\Service\WebSockets\WebSocketProcessor;
use App\AppCore\Domain\Service\WebSockets\WebSocketProcessorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WSServerCommand extends Command
{
    /**
     * @var WebSocketProcessorInterface
     */
    private $webSocketProcessor;
    protected static $defaultName = 'ws-server';

    /**
     * WSServerCommand constructor.
     * @param WebSocketProcessorInterface $webSocketProcessor
     */
    public function __construct(WebSocketProcessorInterface $webSocketProcessor)
    {
        parent::__construct(self::$defaultName);
        $this->webSocketProcessor = $webSocketProcessor;
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->webSocketProcessor->run();
    }
}
