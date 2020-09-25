<?php
declare(strict_types=1);

namespace App\Framework\Service\Monitor\WebSockets\Context;

/**
 * Class Context
 *
 * @package App\Framework\Service\Monitor\WebSockets\Context
 * @codeCoverageIgnore
 */
class Context implements ContextInterface
{
    const PUSHER_NAME = 'pusher.local';

    private $bindHost = '127.0.0.1';
    private $bindPort = 5555;

    /**
     * @var \ZMQContext
     */
    private $context;

    /**
     * @var \ZMQSocket
     */
    private $socket;

    /**
     * Context constructor.
     * @param \ZMQContext $context
     * @param string $bindHost
     * @param int $bindPort
     * @throws \ZMQSocketException
     */
    public function __construct(\ZMQContext $context, string $bindHost, int $bindPort)
    {
        $this->context = $context;
        $this->bindPort = $bindPort;
        $this->bindHost = $bindHost;
        $this->socket = $this->context->getSocket(\ZMQ::SOCKET_PUSH, self::PUSHER_NAME);
        $this->socket->connect("tcp://" . $this->bindHost . ":" . $this->bindPort);
    }

    /**
     * @param array $entryData
     * @throws \ZMQSocketException
     */
    public function send(array $entryData)
    {
        $this->socket->send(\json_encode($entryData));
    }
}
