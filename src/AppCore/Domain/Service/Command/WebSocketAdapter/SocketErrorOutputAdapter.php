<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\Command\OutputAdapterInterface;
use App\AppCore\Domain\Service\WebSockets\WrappedContext;

class SocketErrorOutputAdapter implements OutputAdapterInterface
{
    const ERROR_KEY = 'error';
    const DIR_KEY = 'index';

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
     * @param string $dir
     * @throws \ZMQSocketException
     */
    public function writeln(string $message, string $dir)
    {
        $this->context->send($this->createEntry($message, $dir));
    }

    /**
     * @param string $message
     * @param string $dir
     * @return array
     */
    private function createEntry(string $message, string $dir): array
    {
        return [
            self::ERROR_KEY => $message,
            self::DIR_KEY => $dir
        ];
    }
}
