<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\Command\OutputAdapterInterface;
use App\AppCore\Domain\Service\WebSockets\WrappedContext;
use App\AppCore\Domain\Service\WebSockets\WrappedContextInterface;

class SocketErrorOutputAdapter implements OutputAdapterInterface
{
    const ERROR_KEY = 'error';
    const INDEX_KEY = 'index';

    /**
     * @var WrappedContextInterface
     */
    protected $context;

    /**
     * SocketErrorOutputAdapter constructor.
     *
     * @param WrappedContextInterface $context
     */
    public function __construct(WrappedContextInterface $context)
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
    public function createEntry(string $message, string $dir): array
    {
        return [
            self::ERROR_KEY => $message,
            self::INDEX_KEY => $dir
        ];
    }
}
