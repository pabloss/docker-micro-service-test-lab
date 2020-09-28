<?php
declare(strict_types=1);

namespace App\Framework\Application\Monitor;

use App\AppCore\Domain\Repository\TestRepositoryInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Hub
{
    /**
     * @var TestRepositoryInterface
     */
    private $testRepository;
    /**
     * @var AMQPStreamConnection
     */
    private $consumer;

    /**
     * Hub constructor.
     *
     * @param TestRepositoryInterface $testRepository
     * @param Consumer                $consumer
     */
    public function __construct(TestRepositoryInterface $testRepository, Consumer $consumer)
    {
        $this->testRepository = $testRepository;
        $this->consumer = $consumer;
    }

    /**
     * Porównanie to odpytanie z kolejki
     * @param string $uuid
     *
     * @return string
     */
    public function compare(string $uuid)
    {
        return $this->testRepository->findByHash($uuid)->getRequestedBody() === $this->consumer->consume($uuid) ? 'PASSED': 'FAILED';
    }

    /**
     * @param string $content
     * @param string $header
     *
     * @return AMQPChannel
     * @throws \Exception
     */
    public function receive(string $content, string $header): AMQPChannel
    {
        $queueConnection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $queueConnection->channel();
        $channel->queue_declare('rpc_queue', false, false, false, false);
        $channel->basic_qos(null, 1, null);
        $channel->basic_consume('rpc_queue', '', false, false, false, false, function ($req) use ($content, $header) {
            $msg = new AMQPMessage($content, ['correlation_id' => $header]);
            $req->delivery_info['channel']->basic_publish(
                $msg,
                '',
                $req->get('reply_to')
            );
            $req->delivery_info['channel']->basic_ack(
                $req->delivery_info['delivery_tag']
            );
        });

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $queueConnection->close();

        return $channel;
    }
}
