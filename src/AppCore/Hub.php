<?php
declare(strict_types=1);

namespace App\AppCore;

use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\Framework\Application\Consumer;
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
     */
    public function receive(string $content, string $header): AMQPChannel
    {
        $queueConnection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $queueConnection->channel();
        $channel->exchange_declare($header, 'direct', false, false, false);
        $channel->basic_publish(new AMQPMessage($content), $header, $header);
        return $channel;
    }
}
