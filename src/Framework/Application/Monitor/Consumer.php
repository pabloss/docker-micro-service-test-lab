<?php
declare(strict_types=1);

namespace App\Framework\Application\Monitor;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

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

    private $response;

    private $corr_id;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
        $this->channel = $connection->channel();
    }

    public function consume(string $exchangeName)
    {
        $this->corr_id = $exchangeName;
        list($callbackQueue, , ) = $this->channel->queue_declare("", false, false, true, false);
        $this->channel->basic_consume($callbackQueue, '', false, true, false, false, [$this, 'onResponse']);
        $msg = new AMQPMessage(
            '',
            array(
                'correlation_id' => $this->corr_id,
                'reply_to' => $callbackQueue
            )
        );
        $this->channel->basic_publish($msg, '', 'rpc_queue');
        while (!$this->response) {
            $this->channel->wait();
        }
        $this->channel->close();
        $this->connection->close();

        return $this->response;
    }

    public function onResponse($resp)
    {
        if ($resp->get('correlation_id') == $this->corr_id) {
            $this->response = $resp->body;
        }
    }
}
