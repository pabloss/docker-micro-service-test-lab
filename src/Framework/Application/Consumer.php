<?php
declare(strict_types=1);

namespace App\Framework\Application;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Consumer
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var AMQPChannel
     */
    private $channel;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
        $this->channel = $connection->channel();
    }

    public function consume(string $exchangeName)
    {
        $this->channel->exchange_declare($exchangeName, 'direct', false, false, false);
        list($queueName, , ) = $this->channel->queue_declare("",  false, false, true, false);
        $this->channel->queue_bind($queueName, $exchangeName, $exchangeName);
        $result = '';
        $this->channel->basic_consume($queueName,  '', false, true, false, false, function ($msg) use (&$result) {
            $result = $msg->body;
        });

        while($this->channel->is_consuming() && empty($result)) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();

        return $result;
    }
}
