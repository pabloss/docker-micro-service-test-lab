<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Command\FetchOutInterface;
use App\AppCore\Domain\Service\Command\OutputAdapterInterface;
use App\AppCore\Domain\Service\WebSockets\WrappedContext;

class SocketErrorOutputAdapter implements OutputAdapterInterface, FetchOutInterface
{
    const ERROR_KEY = 'error';

    /**
     * @var WrappedContext
     */
    protected $context;

    /**
     * SocketErrorOutputAdapter constructor.
     * @param WrappedContext $context
     */
    public function __construct(WrappedContext $context)
    {
        $this->context = $context;
    }

    /**
     * @param string $message
     * @throws \ZMQSocketException
     */
    public function writeln(string $message)
    {
        $this->context->send($this->createEntry($message));
    }

    /**
     * @param $pipes
     * @return bool
     * @throws \ZMQSocketException
     */
    public function fetchedOut($pipes): bool
    {
        $out = fgets($pipes[CommandProcessor::STDERR]);
        flush();
        if(isset($out) && \is_string($out)){
            $this->writeln($out);
            return true;
        }
        return false;
    }

    /**
     * @param string $message
     * @return array
     */
    protected function createEntry(string $message): array
    {
        return [
            self::ERROR_KEY => $message
        ];
    }
}
