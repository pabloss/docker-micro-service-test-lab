<?php
declare(strict_types=1);

namespace App\Framework\Application\Monitor;

class Consumer
{
    const LOOP_LIMIT = 10;
    const REDIS_HOST = "127.0.0.1";

    public function consume(string $exchangeName)
    {
        $loopCount = 0;
        $response = null;
        $redis = new \Redis();
        $redis->pconnect(self::REDIS_HOST);
        // wait for key of $exchangeName
        while($loopCount < self::LOOP_LIMIT && empty($response = $redis->get($exchangeName))){
            \sleep(1);
            $loopCount++;
        }
        $redis->del($exchangeName);
        return $response;
    }
}
