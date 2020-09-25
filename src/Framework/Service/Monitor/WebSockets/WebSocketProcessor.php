<?php
declare(strict_types=1);

namespace App\Framework\Service\Monitor\WebSockets;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\Wamp\WampServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\Server;
use React\ZMQ\Context;

/**
 * Class WebSocketProcessor
 *
 * @package App\Framework\Service\Monitor\WebSockets
 * @codeCoverageIgnore
 */
class WebSocketProcessor implements WebSocketProcessorInterface
{
    private $bindHost = '127.0.0.1';
    private $bindPort = 5555;
    private $wsPort = 4444;
    private $wsBroadcastAddress = '0.0.0.0';

    /**
     * WSServerCommand constructor.
     * @param string $bindHost
     * @param int $bindPort
     * @param int $wsPort
     * @param string $wsBroadcastAddress
     */
    public function __construct(string $bindHost, int $bindPort, int $wsPort, string $wsBroadcastAddress)
    {
        $this->bindHost = $bindHost;
        $this->bindPort = $bindPort;
        $this->wsPort = $wsPort;
        $this->wsBroadcastAddress = $wsBroadcastAddress;
    }

    public function run()
    {
        $loop   = Factory::create();
        $pusher = new Pusher();

        // Listen for the web server to make a ZeroMQ push after an ajax request
        $context = new Context($loop);
        $pull = $context->getSocket(\ZMQ::SOCKET_PULL);
        $pull->bind('tcp://' . $this->bindHost . ':' . $this->bindPort);
        $pull->on('message', array($pusher, 'onMsg'));

        // Set up our WebSocket server for clients wanting real-time updates
        $webSock = new Server($this->wsBroadcastAddress . ':' . $this->wsPort, $loop); // Binding to 0.0.0.0 means remotes can connect
        $webServer = new IoServer(
            new HttpServer(
                new WsServer(
                    new WampServer(
                        $pusher
                    )
                )
            ),
            $webSock
        );

        $loop->run();
    }
}
