<?php
declare(strict_types=1);

namespace App\Framework\Application\Monitor;

class Consumer
{
    public function consume(string $exchangeName)
    {
        $redis = new \Redis();
        $redis->pconnect("127.0.0.1");
        // wait for key of $exchangeName
        while(empty($response = $redis->get($exchangeName))){
            $redis->del($exchangeName);
            \sleep(1);
        }
        return $response;
    }
}
