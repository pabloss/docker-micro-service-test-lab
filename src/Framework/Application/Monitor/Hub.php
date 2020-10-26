<?php
declare(strict_types=1);

namespace App\Framework\Application\Monitor;

use App\AppCore\Domain\Actors\TestDTO;
use App\Framework\Service\Test\Connection;

class Hub
{
    const REDIS_HOST = '127.0.0.1';
    /**
     * @var Consumer
     */
    private $consumer;
    /**
     * @var Connection
     */
    private $connection;

    /**
     * Hub constructor.
     *
     * @param Consumer   $consumer
     * @param Connection $connection
     */
    public function __construct(Consumer $consumer, Connection $connection)
    {
        $this->consumer = $consumer;
        $this->connection = $connection;
    }

    /**
     * Porównanie to odpytanie z kolejki
     *
     * @param TestDTO $testDTO
     *
     * @return string
     */
    public function compare(TestDTO $testDTO)
    {
        return $testDTO->getRequestedBody() === $this->consumer->consume($this->chooseUuid($testDTO)) ? 'PASSED': 'FAILED';
    }

    public function receiveRequest(string $header, string $content): void
    {
        $redis = new \Redis();
        $redis->pconnect(self::REDIS_HOST);
        $redis->set($header, $content);
    }

    private function chooseUuid(TestDTO $testDTO)
    {
        if(!(empty($nextUuid = $this->connection->getNextUuid($testDTO->getUuid())))){
            return $nextUuid;
        }
        return $testDTO->getUuid();
    }
}
