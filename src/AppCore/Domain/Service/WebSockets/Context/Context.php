<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\WebSockets\Context;

class Context
{
    const PORT_TO_CONNECT_SOCKET = "5555";
    const HOST_TO_CONNECT_SOCKET = "127.0.0.1";
    const PUSHER_NAME = 'pusher.local';
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
     * @throws \ZMQSocketException
     */
    public function __construct(\ZMQContext $context)
    {
        $this->context = $context;
        $this->socket = $this->context->getSocket(\ZMQ::SOCKET_PUSH, self::PUSHER_NAME);
        $this->socket->connect("tcp://" . self::HOST_TO_CONNECT_SOCKET . ":" . self::PORT_TO_CONNECT_SOCKET);
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
