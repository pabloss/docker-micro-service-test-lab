<?php
declare(strict_types=1);

namespace App\Framework\Command;

use App\Framework\Service\WebSockets\Pusher;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\Wamp\WampServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\Server;
use React\ZMQ\Context;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WSServerCommand extends Command
{
    const BIND_HOST = '127.0.0.1';
    const BIND_PORT = '5555';
    const WS_PORT = '4444';
    const WS_BROADCAST_ADDRESS = '0.0.0.0';
    protected static $defaultName = 'ws-server';

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop   = Factory::create();
        $pusher = new Pusher();

        // Listen for the web server to make a ZeroMQ push after an ajax request
        $context = new Context($loop);
        $pull = $context->getSocket(\ZMQ::SOCKET_PULL);
        $pull->bind('tcp://' . self::BIND_HOST . ':' . self::BIND_PORT);
        $pull->on('message', array($pusher, 'onMsg'));

        // Set up our WebSocket server for clients wanting real-time updates
        $webSock = new Server(self::WS_BROADCAST_ADDRESS . ':' . self::WS_PORT, $loop); // Binding to 0.0.0.0 means remotes can connect
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
