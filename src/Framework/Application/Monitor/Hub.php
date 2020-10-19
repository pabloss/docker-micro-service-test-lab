<?php
declare(strict_types=1);

namespace App\Framework\Application\Monitor;

use App\AppCore\Domain\Repository\TestRepositoryInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

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
}
